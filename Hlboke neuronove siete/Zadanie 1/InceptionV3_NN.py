import utils
import numpy
import cv2
from tensorflow.keras.applications import InceptionV3
from tensorflow.keras.models import Sequential, Model
from tensorflow.keras.layers import Dropout, Dense, GlobalAveragePooling2D
from tensorflow.keras import optimizers
from sklearn.model_selection import train_test_split
from PIL import Image
import matplotlib.pyplot as plt


X, Y = utils.load_data(path='dataset')

x_train, x_test, y_train, y_test = train_test_split(X, Y, test_size=0.2)
x_test, x_val, y_test, y_val = train_test_split(x_test, y_test, test_size=0.5)

base_model = InceptionV3(weights='imagenet', include_top=False, input_shape=(256, 256, 3))
base_model.trainable = False

add_model = Sequential()
add_model.add(base_model)
add_model.add(GlobalAveragePooling2D())
add_model.add(Dropout(0.5))
add_model.add(Dense(4, activation='softmax'))

model = add_model
model.compile(loss='categorical_crossentropy',
              optimizer=optimizers.SGD(lr=1e-4, momentum=0.9),
              metrics=['accuracy'])
model.summary()
base_model.summary()



# # ukazka predictu
# testImgPath = 'dataset/Apple___healthy/00a6039c-e425-4f7d-81b1-d6b0e668517e___RS_HL 7669.JPG'
# img = Image.open(testImgPath)
# img.load()
# img_data = numpy.asarray([numpy.asarray(img, dtype=numpy.int16)])
# print()
# pred = list(model.predict(img_data)[0])
# max_value = max(pred)
# max_index = pred.index(max_value)
#
# print('Image from: ' + testImgPath.split('/')[1])
# options = {0: 'Apple___Apple_scab', 1: 'Apple___Black_rot', 2: 'Apple___Cedar_apple_rust', 3: 'Apple___healthy'}
# print('CNN predicted: ' + options.get(max_index, 'Invalid_argument'))
# print()

# Nacitanie a ulozenie filtrov prvej a druhej conv2d

# layer1 - conv2d (None, 127, 127, 32)
# layer2 - batch_normalization
# layer3 - activation
# layer4 - conv2d (None, 125, 125, 32)
# layer5 - batch_normalization
# layer6 - activation

layer = base_model.layers[4]
filters = base_model.layers[4].get_weights()[0]
for pc in range(32):
    filterImage = []
    for row in range(3):
        filterImage.append([])
        for col in range(3):
            filterImage[row].append([])
            filterImage[row][col] = [filters[row][col][0][pc], filters[row][col][1][pc], filters[row][col][2][pc]]
    filterImage = numpy.array(filterImage)
    filterImage = filterImage - filterImage.min()
    filterImage = filterImage / filterImage.max()
    filterImage = filterImage * 255
    filterImage = cv2.resize(filterImage, (500, 500), interpolation=cv2.INTER_NEAREST)
    cv2.imwrite('filters/filter{}.jpg'.format(pc), filterImage)

# Vykreslenie map priynakov
model1 = Model(inputs=base_model.inputs, outputs=base_model.layers[4].output)
testImgPath = 'dataset/Apple___healthy/00a6039c-e425-4f7d-81b1-d6b0e668517e___RS_HL 7669.JPG'
img = Image.open(testImgPath)
img.load()
img_data = numpy.asarray([numpy.asarray(img, dtype=numpy.int16)])
feature_maps = model1.predict(img_data)

ix = 0
for _ in range(8):
    for _ in range(4):
        ax = plt.subplot(8, 4, ix+1)
        ax.set_xticks([])
        ax.set_yticks([])
        plt.imshow(feature_maps[0, :, :, ix], cmap='gray')
        ix += 1
plt.show()

# Trenovanie siete
history = model.fit(x_train, y_train, epochs=1, batch_size=32, validation_data=(x_val, y_val))

utils.plot_acc(history)
utils.score_nn(model, x_test, y_test)
utils.confusion_matrix_print(model, x_test, y_test)
