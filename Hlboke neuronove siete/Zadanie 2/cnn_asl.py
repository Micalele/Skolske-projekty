import os
from PIL import Image
import numpy
import matplotlib.pyplot as plt
from tensorflow.keras.models import Sequential, Model
from tensorflow.keras.layers import Dropout, Activation, Flatten, Conv2D, MaxPooling2D, Dense, GlobalAveragePooling2D, \
    BatchNormalization, concatenate
from sklearn.model_selection import train_test_split
from sklearn.metrics import ConfusionMatrixDisplay
from sklearn.metrics import confusion_matrix
from keras.utils.np_utils import to_categorical


def load_data_H(path='Gesta_ASL_skupina8_upravene'):
    x = []
    y = []
    image_class = -1
    temp = 0
    for directory in os.listdir(path):
        image_class += 1
        for image in os.listdir(path + '/' + directory):
            print(temp)
            temp = temp + 1
            img = Image.open(path + '/' + directory + '/' + image)
            img = img.resize((256, 256))
            img.load()
            img_data = numpy.asarray(img, dtype=numpy.int16)
            print()
            x.append(img_data)
            y.append(image_class)
    x = numpy.asarray(x)
    y = to_categorical(y, num_classes=6)
    return x, y


def cnn_asl(x, y):
    x_train, x_test, y_train, y_test = train_test_split(x, y, test_size=0.2)
    x_train, x_val, y_train, y_val = train_test_split(x_train, y_train, test_size=0.5)

    model = Sequential()
    model.add(Conv2D(16, (3, 3), padding='valid', input_shape=(440, 440, 3)))
    model.add(BatchNormalization())
    model.add(Activation('relu'))

    model.add(Conv2D(32, (3, 3)))
    model.add(Activation('relu'))

    model.add(MaxPooling2D(pool_size=(2, 2)))
    model.add(Dropout(0.1))

    model.add(Conv2D(32, (3, 3)))
    model.add(Activation('relu'))

    model.add(MaxPooling2D(pool_size=(2, 2)))
    model.add(Dropout(0.1))

    model.add(Flatten())
    model.add(Dense(256, activation='relu'))
    model.add(Dense(256, activation='relu'))
    model.add(Dense(6, activation='softmax'))

    model.compile(loss='categorical_crossentropy',
                  optimizer='adam',
                  metrics=['accuracy'])

    history = model.fit(x_train, y_train, epochs=1, batch_size=32, validation_data=(x_val, y_val))

    scores = model.evaluate(x_test, y_test, verbose=0)
    print("Accuracy: %.2f%%" % (scores[1] * 100))

    # GRAPHS
    # summarize history for accuracy
    plt.plot(history.history['accuracy'])
    plt.plot(history.history['val_accuracy'])
    plt.title('model accuracy')
    plt.ylabel('accuracy')
    plt.xlabel('epoch')
    plt.legend(['train', 'test'], loc='upper left')
    plt.show()

    # summarize history for loss
    plt.plot(history.history['loss'])
    plt.plot(history.history['val_loss'])
    plt.title('model loss')
    plt.ylabel('loss')
    plt.xlabel('epoch')
    plt.legend(['train', 'test'], loc='upper left')
    plt.show()

    # conf matrix
    y_pred = model.predict(x_test)
    conf = confusion_matrix([numpy.argmax(y, axis=None, out=None) for y in y_pred],
                            [numpy.argmax(y, axis=None, out=None) for y in y_test])

    disp = ConfusionMatrixDisplay(confusion_matrix=conf, display_labels=[0, 1, 2, 3, 4, 5])
    disp.plot()
    plt.show()
    return history


def main():
    x, y = load_data_H('Gesta_ASL_skupina8_upravene')
    # x = numpy.expand_dims(x, axis=4)
    print()
    h = cnn_asl(x, y)
    print()


if __name__ == '__main__':
    main()
