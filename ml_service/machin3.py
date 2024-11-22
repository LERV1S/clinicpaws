import pandas as pd
from sklearn.preprocessing import LabelEncoder
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import accuracy_score
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.compose import ColumnTransformer
from sklearn.pipeline import Pipeline
import pickle

# Cargar el dataset
data = pd.read_csv("ml_service/balanced_data-t.csv", encoding='latin1')

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

# Asegurarse de que los valores NaN sean reemplazados por cadenas vacías
data[symptom_columns] = data[symptom_columns].fillna('')

# Dividir los datos en características (X) y la variable objetivo (y)
X = data[symptom_columns + ['AnimalName']]  # Incluir síntomas como columnas separadas más 'AnimalName'
y = data['Dangerous']

# Preprocesamiento: Usar TfidfVectorizer para cada una de las columnas de síntomas
preprocessor = ColumnTransformer(
    transformers=[
        ('symptom1', TfidfVectorizer(), 'symptoms1'),
        ('symptom2', TfidfVectorizer(), 'symptoms2'),
        ('symptom3', TfidfVectorizer(), 'symptoms3'),
        ('symptom4', TfidfVectorizer(), 'symptoms4'),
        ('symptom5', TfidfVectorizer(), 'symptoms5'),
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
with open('ml_service/Modelo.pkl', 'wb') as file:
    pickle.dump(model, file)

# Guardar el LabelEncoder de animales
with open('ml_service/animal_label_encoder.pkl', 'wb') as file:
    pickle.dump(animal_label_encoder, file)

print("Modelo y codificador de animales guardados exitosamente.")

# Evaluar el modelo en el conjunto de prueba
y_pred = model.predict(X_test)
accuracy = accuracy_score(y_test, y_pred)
print(f"Precisión del modelo: {accuracy * 100:.2f}%")
