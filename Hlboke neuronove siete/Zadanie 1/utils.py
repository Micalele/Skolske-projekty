import os
from PIL import Image
import numpy
from keras.utils.np_utils import to_categorical
import matplotlib.pyplot as plt
from sklearn.metrics import confusion_matrix


def load_data(path='dataset'):
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
            img.load()
            img_data = numpy.asarray(img, dtype=numpy.int16)
            x.append(img_data)
            y.append(image_class)
    x = numpy.asarray(x)
    y = to_categorical(y, num_classes=4)
    return x, y


def score_nn(model, x_test, y_test):
    scores = model.evaluate(x_test, y_test, verbose=0)
    print("Accuracy: %.2f%%" % (scores[1] * 100))


def plot_acc(history):
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


def confusion_matrix_print(model, x_test, y_test):
    print('*MLP CONFUSION MATRIX:*')
    y_pred = model.predict(x_test)
    print()
    print(confusion_matrix(y_pred, y_test))
