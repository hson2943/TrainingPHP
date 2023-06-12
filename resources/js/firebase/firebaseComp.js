
import { ref, uploadBytes, getDownloadURL, deleteObject } from "firebase/storage";
import { storage } from "./firebase";
import { v4 as uuidv4 } from "uuid";

export const uploadFile = (file) => {
  return new Promise((resolve, reject) => {
    if (!file) {
      reject("No file uploaded");
      return;
    }
    const imageRef = ref(storage, `images/${file.name + uuidv4()}`);
    uploadBytes(imageRef, file).then((snapshot) => {
      getDownloadURL(snapshot.ref).then((url) => {
        resolve(url);
      });
    }).catch((error) => {
    });
  });
};

export const removeFile = (imageUrl) => {
  return new Promise((resolve, reject) => {
    if (!imageUrl) {
      return;
    }
    const imageRef = ref(storage, imageUrl);
    deleteObject(imageRef)
      .then(() => {
        resolve("Image deleted successfully");
      })
      .catch((error) => {
      });
  });
};