from flask import Flask, request, jsonify
import pickle
import pandas as pd
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.compose import ColumnTransformer
from sklearn.pipeline import Pipeline

app = Flask(__name__)

# Cargar el modelo de machine learning entrenado con su pipeline completo
with open('animal_label_encoder.pkl', 'rb') as file:
    model = pickle.load(file)

@app.route('/predict', methods=['POST'])
def predict():
    data = request.get_json()

    # Imprimir datos para depuración
    print("Datos recibidos:", data)

    animal = data['animal'].lower().strip()  # Se usa el nombre directamente sin codificación
    symptoms = data['symptoms']

    # Asegurarse de que los síntomas son una lista de 5 elementos
    symptoms = [symptom if symptom is not None else '' for symptom in symptoms]
    symptoms += [''] * (5 - len(symptoms))  # Completar con cadenas vacías si es necesario

    # Preparar los datos para la predicción
    input_data = pd.DataFrame({
        'AnimalName': [animal],  # El nombre del animal ya es texto, no es necesario transformarlo
        'symptoms1': [symptoms[0]], 'symptoms2': [symptoms[1]],
        'symptoms3': [symptoms[2]], 'symptoms4': [symptoms[3]], 'symptoms5': [symptoms[4]]
    })

    # Realizar la predicción usando el modelo entrenado
    prediction = model.predict(input_data)[0]

    # Convertir la predicción en una clasificación legible
    prediction_result = "Alto riesgo para la salud" if prediction == 1 else "Bajo riesgo para la salud"

    # Devuelve el resultado de la predicción
    return jsonify({'prediction': prediction_result})

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)
