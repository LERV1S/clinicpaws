from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.base import TransformerMixin

class CustomTfidfVectorizer(TfidfVectorizer, TransformerMixin):
    def fit_transform(self, X, y=None):
        X = [x if isinstance(x, str) and x.strip() != '' else 'empty' for x in X]
        return super().fit_transform(X, y)

    def transform(self, X):
        X = [x if isinstance(x, str) and x.strip() != '' else 'empty' for x in X]
        return super().transform(X)
