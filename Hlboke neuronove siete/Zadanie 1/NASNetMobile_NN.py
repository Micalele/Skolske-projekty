import utils
from tensorflow.keras.applications import NASNetMobile
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import Dropout, Dense, GlobalAveragePooling2D
from tensorflow.keras import optimizers
from tensorflow.image import resize
from sklearn.model_selection import train_test_split


X, Y = utils.load_data(path='dataset')

x_train, x_test, y_train, y_test = train_test_split(X, Y, test_size=0.2)
x_test, x_val, y_test, y_val = train_test_split(x_test, y_test, test_size=0.5)

x_train = resize(x_train, (224, 224))
x_test = resize(x_test, (224, 224))
x_val = resize(x_val, (224, 224))

base_model = NASNetMobile(include_top=False, weights="imagenet")
base_model.trainable = True

add_model = Sequential()
add_model.add(base_model)
add_model.add(GlobalAveragePooling2D())
add_model.add(Dropout(0.5))
add_model.add(Dense(4, activation='softmax'))

model = add_model
# opt = Adam(learning_rate=0.001)
model.compile(loss='categorical_crossentropy',
              optimizer=optimizers.SGD(lr=1e-4, momentum=0.9),
              metrics=['accuracy'])
model.summary()
history = model.fit(x_train, y_train, epochs=20, batch_size=32, validation_data=(x_val, y_val))

utils.plot_acc(history)
utils.score_nn(model, x_test, y_test)
utils.confusion_matrix_print(model, x_test, y_test)
