import numpy as np
import pandas as pd

P = [0.15, 0.10, 0.05, 0.10, 0.20]
Q = [0.05, 0.10, 0.05, 0.05, 0.05, 0.10]
n = len(P)

p = pd.Series(P, index=range(1, n+1))
q = pd.Series(Q)

e = pd.DataFrame(np.diag(Q), index=range(1, n+2))
w = pd.DataFrame(np.diag(Q), index=range(1, n+2))
root = pd.DataFrame(np.zeros((n, n)), index=range(1, n+1), columns=range(1, n+1))

for l in range(1, n+1):
    for i in range(1, n-l+2):
        j = i+l-1
        e.set_value(i, j, np.inf)
        w.set_value(i, j, w.get_value(i, j-1) + p[j] + q[j])
        for r in range(i, j+1):
            t = e.get_value(i, r-1) + e.get_value(r+1, j) + w.get_value(i, j)
            if t < e.get_value(i, j):
                e.set_value(i, j, t)
                root.set_value(i, j, r)

print(e)
print(w)
print(root)
