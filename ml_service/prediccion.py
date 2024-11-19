from flask import Flask, request, jsonify 
import joblib 
import numpy as np  

app = Flask(__name__)  

# Cargar modelo entrenado 
try:     
	model = joblib.load('model.pkl') 
except Exception as e:     
	print(f"Error al cargar el modelo: {e}")     
	model = None  

@app.route('/predict', methods=['POST']) 
def predict():     

	# Verificar que el modelo está cargado     
	if model is None:
		return jsonify({'error': 'El modelo no se pudo cargar. Verifique el servidor.'}), 500      
	try:         
	
		# Obtener datos JSON de la solicitud         
		data = request.get_json()          
		
		# Validar las entradas         
		if 'symptoms' not in data or 'animal' not in data:             
			return jsonify({'error': 'Faltan datos requeridos: "symptoms" o "animal".'}), 400          
		
		symptoms = data['symptoms']         
		
		if not isinstance(symptoms, list) or len(symptoms) > 5:             
			return jsonify({'error': '"symptoms" debe ser una lista con un máximo de 5 elementos.'}), 400          

		# Convertir los datos a formato numpy para el modelo         
		features = np.array([symptoms])         

		# Realizar la predicción         
		prediction = model.predict(features)          

		# Retornar la respuesta JSON         
		return jsonify({'prediction': int(prediction[0])})  # Convertir la predicción a entero si es necesario     
	except Exception as e:         
		print(f"Error al procesar la solicitud: {e}")         
		return jsonify({'error': 'Ocurrió un error al realizar la predicción. Verifique los datos.'}), 500  

if __name__ == '__main__':     
	app.run(host='0.0.0.0', port=5000)
