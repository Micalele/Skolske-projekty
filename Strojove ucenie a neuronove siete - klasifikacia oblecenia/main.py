# import keras
import os
import numpy
# import matplotlib.pyplot as plt
import pandas as pandas
import tensorflow as tf
import cv2
import time
from sklearn.model_selection import train_test_split
from keras_preprocessing.image import ImageDataGenerator
from tensorflow.keras.optimizers import Adam
from tensorflow.keras.callbacks import TensorBoard
from tensorflow.keras.callbacks import ModelCheckpoint
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import Dropout, Activation, Flatten, Conv2D, MaxPooling2D, Dense

NAME = "Gender-classification-{}".format(int(time.time()))

if __name__ == '__main__':
    styles = pandas.read_csv("data/styles.csv", usecols=['id', 'gender'])
    unique = styles['gender'].unique()

    # img = cv2.imread("data/images/1163.jpg")
    # img = cv2.resize(img, (60, 60))
    # img = img / 255
    # cv2.imshow("daco", img)
    # cv2.waitKey(0)
    # print()

    imageList = []
    genderList = []
    pc = 0
    for row in styles.iterrows():
        if pc >= 2000:
            break
        else:
            pc = pc + 1
        filename = "data/images/" + str(row[1]['id']) + ".jpg"
        if os.path.exists(filename) and os.path.isfile(filename):
            # print(row[0])
            # img = cv2.imread(filename)
            # img = cv2.resize(img, (60, 60))
            # img = img / 255
            # img = img.tolist()
            imageList.append(str(row[1]['id']) + ".jpg")
            genderList.append(row[1]['gender'])
    print()
    x_train, x_test, y_train, y_test = train_test_split(imageList, genderList, test_size=0.1)
    # x_val, x_test, y_val, y_test = train_test_split(x_test, y_test, test_size=0.5)
    # y_train = pandas.get_dummies(pandas.DataFrame(y_train)).values.tolist()
    # y_test = pandas.get_dummies(pandas.DataFrame(y_test)).values.tolist()
    # y_val = pandas.get_dummies(pandas.DataFrame(y_val)).values.tolist()
    trainDF = pandas.DataFrame(numpy.column_stack([x_train, y_train]), columns=['id', 'gender'])
    testDF = pandas.DataFrame(numpy.column_stack([x_test, y_test]), columns=['id', 'gender'])

    print()
    path = os.getcwd()
    dataPath = path + "/data/images/"
    imgHeightWidth = 60

    trainDataGenerator = ImageDataGenerator(rescale=1 / 255, validation_split=0.1)
    testDataGenerator = ImageDataGenerator(rescale=1 / 255)

    trainGenerator = trainDataGenerator.flow_from_dataframe(dataframe=trainDF,
                                                            directory=dataPath,
                                                            x_col='id',
                                                            y_col='gender',
                                                            target_size=(imgHeightWidth, imgHeightWidth),
                                                            batch_size=25,
                                                            subset="training",
                                                            class_mode="categorical")

    valGenerator = trainDataGenerator.flow_from_dataframe(dataframe=trainDF,
                                                          directory=dataPath,
                                                          x_col='id',
                                                          y_col='gender',
                                                          target_size=(imgHeightWidth, imgHeightWidth),
                                                          batch_size=25,
                                                          subset="validation",
                                                          class_mode="categorical")

    testGenerator = testDataGenerator.flow_from_dataframe(dataframe=testDF,
                                                          directory=dataPath,
                                                          x_col='id',
                                                          y_col='gender',
                                                          target_size=(imgHeightWidth, imgHeightWidth),
                                                          batch_size=25,
                                                          class_mode="categorical")
    print()
    # checkpoints
    checkpointPath = "checkPoints/{}".format(NAME)
    checkpointCallBack = ModelCheckpoint(filepath=checkpointPath,
                                         save_weights_only=True,
                                         monitor="val_accuracy",
                                         mode="max")

    # trenovanie

    tensorboard = TensorBoard(log_dir="TensorBoardLogs/{}".format(NAME))

    optimizer = Adam(learning_rate=0.001)

    model = Sequential()
    model.add(Conv2D(36, (10, 10),
                     padding='same',
                     input_shape=(60, 60, 3)))
    model.add(Activation('relu'))

    model.add(Conv2D(72, (10, 10)))
    model.add(Activation('relu'))

    model.add(MaxPooling2D(pool_size=(2, 2)))
    model.add(Dropout(0.25))

    model.add(Conv2D(72, (10, 10)))
    model.add(Activation('relu'))

    model.add(MaxPooling2D(pool_size=(2, 2)))
    model.add(Dropout(0.25))

    model.add(Flatten())

    model.add(Dense(1296, activation='relu'))
    model.add(Activation('relu'))
    model.add(Dropout(0.5))

    model.add(Dense(5, activation='softmax'))

    model.compile(optimizer=optimizer,
                  loss='categorical_crossentropy',
                  metrics=['accuracy'])

    history = model.fit(trainGenerator,
                        steps_per_epoch=1620 // 25,
                        epochs=12,
                        validation_data=valGenerator,
                        callbacks=[tensorboard, checkpointCallBack],
                        validation_steps=180 // 25)

    # vykreslenie filtrov
    filters, biases = model.layers[0].get_weights()
    for pc in range(36):
        filterImage = []
        for row in range(10):
            filterImage.append([])
            for col in range(10):
                filterImage[row].append([])
                filterImage[row][col] = [filters[row][col][0][pc], filters[row][col][1][pc], filters[row][col][2][pc]]
        filterImage = numpy.array(filterImage)
        filterImage = filterImage - filterImage.min()
        filterImage = filterImage / filterImage.max()
        filterImage = filterImage * 255
        filterImage = cv2.resize(filterImage, (500, 500), interpolation=cv2.INTER_NEAREST)
        cv2.imwrite('filters/filter{}.jpg'.format(pc), filterImage)

    # evaluate the model
    scores = model.evaluate(testGenerator, verbose=0, callbacks=[tensorboard])
    print("%s: %.2f%%" % (model.metrics_names[1], scores[1] * 100))
    print()
