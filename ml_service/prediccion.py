from flask import Flask, request, jsonify
import pandas as pd
import numpy as np
import joblib
import pickle

app = Flask(__name__)

# Cargar el modelo y los codificadores
model = joblib.load('model.pkl')

# Cargar el LabelEncoder para AnimalName
with open('animal_label_encoder.pkl', 'rb') as file:
    animal_label_encoder = pickle.load(file)

# Cargar los LabelEncoders
animal_label_encoder = joblib.load('animal_label_encoder.pkl')

@app.route('/predict', methods=['POST'])
def predict():
    try:
        # Obtener datos JSON enviados por el cliente
        data = request.json

        # Validar las entradas
        if 'animal' not in data or 'symptoms' not in data:
            return jsonify({'error': 'Faltan datos requeridos: "animal" o "symptoms".'}), 400

        # Procesar el animal
        animal = data['animal'].lower().strip()
        if animal not in animal_label_encoder.classes_:
            return jsonify({'error': f'El animal "{animal}" no está registrado.'}), 400

        animal_encoded = animal_label_encoder.transform([animal])[0]

        # Procesar los síntomas
        symptoms = data['symptoms']
        if len(symptoms) > 5:
            return jsonify({'error': 'El modelo solo acepta hasta 5 síntomas.'}), 400

        # Rellenar con cadenas vacías si hay menos de 5 síntomas
        symptoms += [''] * (5 - len(symptoms))

        # Crear un DataFrame con las características
        input_data = pd.DataFrame({
            'AnimalName': [animal_encoded],
            'symptoms1': [symptoms[0]], 'symptoms2': [symptoms[1]],
            'symptoms3': [symptoms[2]], 'symptoms4': [symptoms[3]],
            'symptoms5': [symptoms[4]]
        })

        # Realizar la predicción
        prediction = model.predict(input_data)

        # Interpretar el resultado
        return jsonify({'prediction': int(prediction[0])})
    except Exception as e:
        return jsonify({'error': f'Error al procesar la solicitud: {str(e)}'}), 500

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)
