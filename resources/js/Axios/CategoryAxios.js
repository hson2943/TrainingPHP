import { ref } from 'vue'
import axios from "axios";

export default function getDataCategory() {
    const categories = ref([])
    const filterbrands = ref([])
    const getCategories = async () => {
        let response = await axios.get('http://127.0.0.1:8000/api/categories')
        categories.value = response.data.data
    }
    const filteredBrands = async (category_id) => {
        axios.get(`http://127.0.0.1:8000/api/brandsByCategory/${category_id}`)
            .then(res => {
                filterbrands.value = res.data.data.brands
            })
    }
    return {
        categories,
        getCategories,
        filterbrands,
        filteredBrands
    }
}