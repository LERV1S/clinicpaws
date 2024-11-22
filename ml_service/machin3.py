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
with open('ml_service/animal_label_encoder.pkl', 'wb') as file:
    pickle.dump(model, file)

print("Modelo guardado exitosamente en 'animal_label_encoder.pkl'.")

# Evaluar el modelo en el conjunto de prueba
y_pred = model.predict(X_test)
accuracy = accuracy_score(y_test, y_pred)
print(f"Precisión del modelo: {accuracy * 100:.2f}%")

# Función para predecir el nivel de riesgo de salud del animal según sus síntomas, usando probabilidades
def predict_health_risk(animal, symptoms):
    # Normalizar el nombre del animal
    animal = animal.lower().strip()

    # Manejo de animales no vistos durante el entrenamiento
    if animal not in animal_label_encoder.classes_:
        print(f"El animal '{animal}' no fue visto durante el entrenamiento. Se usará un valor genérico.")
        animal = 'dog'  # Usar un valor genérico

    # Si hay menos de cinco síntomas, rellenar con cadenas vacías
    symptoms += [''] * (5 - len(symptoms))  # Reemplazar None por cadenas vacías

    # Codificar el animal
    input_data = pd.DataFrame({
        'AnimalName': [animal_label_encoder.transform([animal])[0]],
        'symptoms1': [symptoms[0]], 'symptoms2': [symptoms[1]],
        'symptoms3': [symptoms[2]], 'symptoms4': [symptoms[3]],
        'symptoms5': [symptoms[4]]
    })

    # Predecir las probabilidades de cada clase
    prediction_proba = model.predict_proba(input_data)

    # Definir umbrales para diferentes niveles de riesgo
    high_risk_threshold = 0.7  # Umbral para alto riesgo
    moderate_risk_threshold = 0.4  # Umbral para riesgo moderado

    # Clasificar en base a los umbrales
    if prediction_proba[0][1] > high_risk_threshold:
        return "Alto riesgo para la salud, se recomienda acudir al veterinario lo más pronto posible"
    elif prediction_proba[0][1] > moderate_risk_threshold:
        return "Riesgo moderado para la salud, se recomienda monitorear y consultar al veterinario si los síntomas persisten"
    else:
        return "Bajo riesgo para la salud, se recomienda mantener la vigilancia"

# Ejemplo de uso con un solo síntoma
new_symptom_low_risk_cat = ['Sneezing']  # Un solo síntoma leve
animal_type_low_risk_cat = 'cat'  # Gato

try:
    prediction_result_low_risk_cat = predict_health_risk(animal_type_low_risk_cat, new_symptom_low_risk_cat)
    print(f"Predicción para {animal_type_low_risk_cat} con síntomas {new_symptom_low_risk_cat}: {prediction_result_low_risk_cat}")
except ValueError as e:
    print(e)

new_symptoms_dog = ['Tos', 'Letargo', 'Vomito']  # Tres síntomas
animal_type_dog = 'Perro'

try:
    prediction_result_dog = predict_health_risk(animal_type_dog, new_symptoms_dog)
    print(f"Predicción para {animal_type_dog} con síntomas {new_symptoms_dog}: {prediction_result_dog}")
except ValueError as e:
    print(e)


new_symptoms_cat = ['Diarrhea']  # Un síntoma leve
animal_type_cat = 'cat'

try:
    prediction_result_cat = predict_health_risk(animal_type_cat, new_symptoms_cat)
    print(f"Predicción para {animal_type_cat} con síntomas {new_symptoms_cat}: {prediction_result_cat}")
except ValueError as e:
    print(e)


new_symptoms_rabbit = ['Drooping ears', 'Nasal discharge', 'Loss of appetite', 'Coughing', 'Lethargy']  # Cinco síntomas
animal_type_rabbit = 'rabbit'

try:
    prediction_result_rabbit = predict_health_risk(animal_type_rabbit, new_symptoms_rabbit)
    print(f"Predicción para {animal_type_rabbit} con síntomas {new_symptoms_rabbit}: {prediction_result_rabbit}")
except ValueError as e:
    print(e)


new_symptoms_horse = ['Sneezing', 'Fever']  # Dos síntomas
animal_type_horse = 'horse'

try:
    prediction_result_horse = predict_health_risk(animal_type_horse, new_symptoms_horse)
    print(f"Predicción para {animal_type_horse} con síntomas {new_symptoms_horse}: {prediction_result_horse}")
except ValueError as e:
    print(e)


new_symptoms_bird = ['Weakness', 'Loss of feathers', 'Drooping wings', 'Lethargy']  # Cuatro síntomas
animal_type_bird = 'bird'

try:
    prediction_result_bird = predict_health_risk(animal_type_bird, new_symptoms_bird)
    print(f"Predicción para {animal_type_bird} con síntomas {new_symptoms_bird}: {prediction_result_bird}")
except ValueError as e:
    print(e)
