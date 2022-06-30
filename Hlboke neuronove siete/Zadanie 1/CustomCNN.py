import utils
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import Dropout, Activation, Flatten, Conv2D, MaxPooling2D, Dense, BatchNormalization
from sklearn.model_selection import train_test_split


X, Y = utils.load_data(path='dataset')

x_train, x_test, y_train, y_test = train_test_split(X, Y, test_size=0.2)
x_test, x_val, y_test, y_val = train_test_split(x_test, y_test, test_size=0.5)

model = Sequential()
model.add(Conv2D(36, (10, 10), padding='same', input_shape=(256, 256, 3)))
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
model.add(Dropout(0.5))

model.add(Dense(4, activation='softmax'))

model.compile(optimizer='adam', loss='categorical_crossentropy', metrics=['accuracy'])
model.summary()
history = model.fit(x_train, y_train, epochs=0, batch_size=32)

# utils.plot_acc(history)
# utils.score_nn(model, x_test, y_test)
utils.confusion_matrix_print(model, x_test, y_test)
