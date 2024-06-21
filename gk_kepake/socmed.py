import joblib
import pandas as pd
from sklearn.preprocessing import LabelEncoder
from sklearn.impute import KNNImputer

# Load the pre-trained model and scaler
dir_path = ''  # Sesuaikan path jika diperlukan
model_social_media = dir_path + 'model/sosmed_knn_model.sav'
scaler_social_media_dir = dir_path + 'model/scaler_socmed_knn.sav'

classifier_social_media = joblib.load(model_social_media)
scaler_social_media = joblib.load(scaler_social_media_dir)

# Load the dataset
data_file = pd.read_csv('dataset/dataset.csv')

# Convert features to numeric, handling any possible errors
# Pisahkan fitur dan label
features = data_file.drop(columns=['User_ID', 'Dominant_Emotion'])

# Encoder untuk Platform
le = LabelEncoder()
features['Platform'] = le.fit_transform(features['Platform'])

# Encode Gender
features['Gender'] = features['Gender'].map({'Female': 0, 'Male': 1, 'Non-binary': 2})

# Filter data yang valid untuk kolom Age
valid_ages = features['Age'].apply(lambda x: x.isnumeric() if isinstance(x, str) else True)  # Hanya pilih data yang berupa angka
features = features[valid_ages]

# Ubah semua data numerik ke float, atau tangani data yang tidak valid
for column in features.columns:
    if features[column].dtype == 'object':
        # Buat kolom ini numerik, jika memungkinkan
        features[column] = pd.to_numeric(features[column], errors='coerce')

# Menggunakan KNNImputer untuk menangani nilai yang hilang
imputer = KNNImputer(n_neighbors=5)
features_imputed = pd.DataFrame(imputer.fit_transform(features), columns=features.columns)

# Ensure the data types are correct after imputation
features_imputed['Age'] = features_imputed['Age'].astype(float)
features_imputed['Platform'] = features_imputed['Platform'].astype(int)
features_imputed['Gender'] = features_imputed['Gender'].astype(int)

# Nama kolom pada fitur
feature_names = ['Age', 'Gender', 'Platform', 'Daily_Usage_Time (minutes)',
                 'Posts_Per_Day', 'Likes_Received_Per_Day', 'Comments_Received_Per_Day',
                 'Messages_Sent_Per_Day']

# Scale the features
try:
    scaled_feature = scaler_social_media.transform(features_imputed)
    # Beri nama kolom pada scaled_feature
    scaled_feature = pd.DataFrame(scaled_feature, columns=feature_names)
except Exception as e:
    print(f"Error in scaling features: {e}")

# Perform classification
try:
    result = classifier_social_media.predict(scaled_feature)
    hasil = pd.DataFrame(result, columns=['Prediction'])
    print(hasil['Prediction'])  # Menampilkan kolom prediksi saja
    hasil['Prediction'].to_csv('hasil.csv', index=False)  # Menyimpan hanya kolom prediksi ke file CSV
except Exception as e:
    print(f"Error in classification: {e}")
