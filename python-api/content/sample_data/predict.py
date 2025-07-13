import sys
import json
import pickle

# Load model dan mapping
with open('storage/app/models/preprocessing.pkl', 'rb') as f:
    model_data = pickle.load(f)

model = model_data['model'] 
label_encoder = model_data['label_encoder']

# Read input data dari argumen
input_json = sys.argv[1]
input_data = json.loads(input_json)

# ... lakukan preprocessing jika perlu

# Prediksi
prediction = model.predict([input_data])

# Output hasil sebagai JSON
print(json.dumps({'prediksi': int(prediction[0])}))
