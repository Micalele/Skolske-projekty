import os
import time
from PIL import Image
import numpy
from tensorflow.keras.applications import InceptionV3
from tensorflow.keras.models import Sequential, Model
from tensorflow.keras.layers import GlobalAveragePooling2D, Dropout, Dense
from tensorflow.keras import optimizers
from sklearn.model_selection import train_test_split
from keras.utils.np_utils import to_categorical
from keras.optimizer_v2.adam import Adam


def load_data(path='dataset'):
    x = []
    y = []
    image_class = -1
    for directory in os.listdir(path):
        image_class += 1
        for image in os.listdir(path + '/' + directory):
            img = Image.open(path + '/' + directory + '/' + image)
            img.load()
            img_data = numpy.asarray(img, dtype=numpy.int16)
            x.append(img_data)
            y.append(image_class)
    x = numpy.asarray(x)
    y = to_categorical(y, num_classes=4)
    return x, y


def inceptionV3(x_train, x_test, y_train, y_test):
    base_model = InceptionV3(weights='imagenet', include_top=False, input_shape=(256, 256, 3))
    base_model.trainable = False

    add_model = Sequential()
    add_model.add(base_model)
    add_model.add(GlobalAveragePooling2D())
    add_model.add(Dropout(0.5))
    add_model.add(Dense(4, activation='softmax'))

    model = add_model
    opt = Adam(learning_rate=0.001)
    model.compile(loss='categorical_crossentropy',
                  optimizer=optimizers.SGD(lr=1e-4, momentum=0.9),
                  metrics=['accuracy'])
    model.summary()
    print()
    history = model.fit(x_train, y_train, epochs=1, batch_size=32, validation_data=(x_test, y_test))
    print()


def main():
    start = time.time()
    X, Y = load_data()
    end = time.time()
    print('Load time: ', end - start, ' seconds')

    # x_train, x_test, y_train, y_test = train_test_split(X, Y, test_size=0.2)
    # inceptionV3(x_train, x_test, y_train, y_test)


if __name__ == '__main__':
    main()
