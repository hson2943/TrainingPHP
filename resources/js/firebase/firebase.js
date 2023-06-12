// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getStorage } from "firebase/storage";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyAVADIy_62AyUOGI6ShQJRd4UCFyuxi5mg",
  authDomain: "database-image-8cf4e.firebaseapp.com",
  projectId: "database-image-8cf4e",
  storageBucket: "database-image-8cf4e.appspot.com",
  messagingSenderId: "369679452317",
  appId: "1:369679452317:web:419fdb816fb9aa7af6ec74"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
export const storage = getStorage(app);