from flask import Flask, request, jsonify
import pickle
import pandas as pd

app = Flask(__name__)

# Cargar el modelo de machine learning entrenado
with open('ml_service/modelo.pkl', 'rb') as file:
    model = pickle.load(file)

# Cargar el codificador de nombres de animales
with open('ml_service/animal_label_encoder.pkl', 'rb') as file:
    animal_label_encoder = pickle.load(file)

@app.route('/predict', methods=['POST'])
def predict():
    data = request.get_json()

    # Imprimir datos para depuración
    print("Datos recibidos:", data)

    animal = data['animal'].lower().strip()
    symptoms = data['symptoms']

    # Reemplazar valores None en síntomas con cadenas vacías
    symptoms = [symptom if symptom is not None else '' for symptom in symptoms]

    # Validar que el animal esté en las clases del codificador
    if animal not in animal_label_encoder.classes_:
        return jsonify({'error': f"Animal '{animal}' no fue visto durante el entrenamiento."}), 400

    # Preparar los datos para la predicción
    input_data = pd.DataFrame({
        'AnimalName': [animal_label_encoder.transform([animal])[0]],
        'symptoms1': [symptoms[0]], 'symptoms2': [symptoms[1]],
        'symptoms3': [symptoms[2]], 'symptoms4': [symptoms[3]],
        'symptoms5': [symptoms[4]]
    })

    # Realizar la predicción
    prediction = model.predict(input_data)[0]
    return jsonify({'prediction': int(prediction)})

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)
