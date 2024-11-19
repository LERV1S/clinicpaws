from flask import Flask, request, jsonify
import pickle
import pandas as pd

app = Flask(__name__)

# Cargar el modelo entrenado desde el archivo
with open('model.pkl', 'rb') as file:
    model = pickle.load(file)

@app.route('/predict', methods=['POST'])
def predict():
    # Obtener los datos del request de Laravel (supone que los síntomas y el nombre del animal se envían en formato JSON)
    data = request.get_json()

    # Crear un DataFrame con los síntomas recibidos
    symptoms = ' '.join([data['symptoms1'], data['symptoms2'], data['symptoms3'], data['symptoms4'], data['symptoms5']])
    df = pd.DataFrame([[data['AnimalName'], symptoms]], columns=['AnimalName', 'Symptoms'])

    # Hacer la predicción
    prediction = model.predict(df)

    # Devolver la predicción como JSON
    return jsonify({'dangerous': bool(prediction[0])})

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=5000)
