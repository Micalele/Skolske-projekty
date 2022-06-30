import matplotlib.pyplot as plt
import numpy
from sklearn.metrics import ConfusionMatrixDisplay

daco = numpy.array([[165, 1, 4, 4],
                    [1, 26, 2, 0],
                    [4, 0, 46, 2],
                    [4, 0, 2, 56]])
disp = ConfusionMatrixDisplay(confusion_matrix=daco, display_labels=[0, 1, 2, 3])
disp.plot()
plt.show()
