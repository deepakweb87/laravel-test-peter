import apiClient from "../utils/axios";

export const submitForm = async (formData) => {
    try {
        const response = await apiClient.post("/submissions", formData);
        return response.data;
    } catch (error) {
        throw error.response ? error.response.data : error;
    }
};
