import pandas as pd
from sklearn.preprocessing import LabelEncoder
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import accuracy_score
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.compose import ColumnTransformer
from sklearn.pipeline import Pipeline
from sklearn.base import TransformerMixin
import joblib
from custom_vectorizer import CustomTfidfVectorizer

# Clase personalizada para manejar cadenas vacías en TfidfVectorizer
class CustomTfidfVectorizer(TfidfVectorizer, TransformerMixin):
    def fit_transform(self, X, y=None):
        X = [x if isinstance(x, str) and x.strip() != '' else 'empty' for x in X]
        return super().fit_transform(X, y)

    def transform(self, X):
        X = [x if isinstance(x, str) and x.strip() != '' else 'empty' for x in X]
        return super().transform(X)

# Cargar el dataset
data = pd.read_csv("ml_service/balanced_data.csv")

# Normalización de los nombres de animales
data['AnimalName'] = data['AnimalName'].str.lower().str.strip()

# Codificar los nombres de animales y la variable 'Dangerous'
animal_label_encoder = LabelEncoder()
data['AnimalName'] = animal_label_encoder.fit_transform(data['AnimalName'])

dangerous_label_encoder = LabelEncoder()
data['Dangerous'] = dangerous_label_encoder.fit_transform(data['Dangerous'])

# Mantener las columnas de síntomas como separadas
symptom_columns = ['symptoms1', 'symptoms2', 'symptoms3', 'symptoms4', 'symptoms5']

# Asegurarse de que solo se incluyan las columnas que realmente existan en el dataset
symptom_columns = [col for col in symptom_columns if col in data.columns]

# Rellenar valores faltantes en las columnas de síntomas
for symptom in symptom_columns:
    data[symptom] = data[symptom].fillna('')

# Dividir los datos en características (X) y la variable objetivo (y)
X = data[symptom_columns + ['AnimalName']]  # Incluir síntomas y 'AnimalName'
y = data['Dangerous']

# Preprocesamiento: Usar CustomTfidfVectorizer para cada una de las columnas de síntomas
preprocessor = ColumnTransformer(
    transformers=[
        ('symptom1', CustomTfidfVectorizer(), 'symptoms1'),
        ('symptom2', CustomTfidfVectorizer(), 'symptoms2'),
        ('symptom3', CustomTfidfVectorizer(), 'symptoms3'),
        ('symptom4', CustomTfidfVectorizer(), 'symptoms4'),
        ('symptom5', CustomTfidfVectorizer(), 'symptoms5'),
    ], remainder='passthrough')

# Crear el pipeline para preprocesar los datos y entrenar el modelo
model = Pipeline([
    ('preprocessor', preprocessor),
    ('clf', RandomForestClassifier(random_state=42, max_depth=10, n_estimators=100))
])

# Dividir los datos en entrenamiento y prueba
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# Entrenar el modelo con los datos de entrenamiento
model.fit(X_train, y_train)

# Guardar el modelo entrenado
joblib.dump(model, 'model.pkl')
print("Modelo guardado exitosamente en 'model.pkl'.")

# Guardar el LabelEncoder para AnimalName
joblib.dump(animal_label_encoder, 'animal_label_encoder.pkl')
print("LabelEncoder guardado exitosamente en 'animal_label_encoder.pkl'.")

# Evaluar el modelo en el conjunto de prueba
y_pred = model.predict(X_test)
accuracy = accuracy_score(y_test, y_pred)
print(f"Precisión del modelo: {accuracy * 100:.2f}%")
