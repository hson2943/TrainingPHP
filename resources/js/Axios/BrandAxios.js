import { ref } from 'vue'
import axios from "axios";

export default function getDataBrand() {
    const brands = ref([])
    const getBrands = async () => {
        const response = await axios.get(`http://127.0.0.1:8000/api/brands`);
        brands.value = response.data.data;
    }

    return {
        brands,
        getBrands,
    }
}