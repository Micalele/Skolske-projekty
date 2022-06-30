import numpy
import cv2
import pandas
from tensorflow.keras.optimizers import Adam
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import Dropout, Activation, Flatten, Conv2D, MaxPooling2D, Dense

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

path = 'checkPoints/Gender-classification-1607496959'
model.load_weights(path)

img = cv2.imread('data/testImages/kilt.jpg')
img = cv2.resize(img, (60, 60))
img = img / 255
img = numpy.expand_dims(img, axis=0)
predict = model.predict(x=img)
predict = pandas.DataFrame(predict, columns=["Boys", "Girls", "Man", "Unisex", "Woman"])
print()
