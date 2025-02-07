<template>
    <div class="container mt-4">
        <h2>Contact Form</h2>
        <form @submit.prevent="handleSubmit">
            <input type="hidden" :value="csrfToken" name="_token" />

            <div v-if="serverErrors.length" class="alert alert-danger">
                <ul>
                    <li v-for="(error, index) in serverErrors" :key="index">{{ error }}</li>
                </ul>
            </div>

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" v-model="form.name" class="form-control" />
                <small v-if="errors.name" class="text-danger">{{ errors.name }}</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" v-model="form.email" class="form-control" />
                <small v-if="errors.email" class="text-danger">{{ errors.email }}</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" v-model="form.phone" class="form-control" />
                <small v-if="errors.phone" class="text-danger">{{ errors.phone }}</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Message</label>
                <textarea v-model="form.message" class="form-control"></textarea>
                <small v-if="errors.message" class="text-danger">{{ errors.message }}</small>
            </div>

            <!-- New Fields -->
            <div class="mb-3">
                <label class="form-label">Street</label>
                <input type="text" v-model="form.street" class="form-control" />
                <small v-if="errors.street" class="text-danger">{{ errors.street }}</small>
            </div>

            <div class="mb-3">
                <label class="form-label">State</label>
                <input type="text" v-model="form.state" class="form-control" />
                <small v-if="errors.state" class="text-danger">{{ errors.state }}</small>
            </div>

            <div class="mb-3">
                <label class="form-label">ZIP Code</label>
                <input type="text" v-model="form.zip" class="form-control" />
                <small v-if="errors.zip" class="text-danger">{{ errors.zip }}</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Country</label>
                <input type="text" v-model="form.country" class="form-control" />
                <small v-if="errors.country" class="text-danger">{{ errors.country }}</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Images (JPG only)</label>
                <input type="file" multiple @change="handleFileUpload($event, 'images')" class="form-control" />
                <small v-if="errors.images" class="text-danger">{{ errors.images }}</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Files (PDF only)</label>
                <input type="file" multiple @change="handleFileUpload($event, 'files')" class="form-control" />
                <small v-if="errors.files" class="text-danger">{{ errors.files }}</small>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</template>

<script>
import useFormValidation from "../composables/useFormValidation";
import { submitForm } from "../services/submissionService";
import { ref } from "vue";

export default {
    setup() {
        const { form, errors, validate } = useFormValidation();
        const csrfToken = ref(document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        const serverErrors = ref([]);

        const handleFileUpload = (event, type) => {
            form[type] = Array.from(event.target.files);
        };

        const handleSubmit = async () => {
            if (!validate()) return;

            const formData = new FormData();
            Object.keys(form).forEach((key) => {
                if (Array.isArray(form[key])) {
                    form[key].forEach((file) => formData.append(`${key}[]`, file));
                } else {
                    formData.append(key, form[key]);
                }
            });

            formData.append("_token", csrfToken.value);

            try {
                await submitForm(formData);
                alert("Submission successful!");
                serverErrors.value = [];
            } catch (error) {
                if (error.response?.data?.errors) {
                    serverErrors.value = Object.values(error.response.data.errors).flat();
                } else {
                    serverErrors.value = ["An error occurred while submitting the form."];
                }
            }
        };

        return { form, errors, handleSubmit, handleFileUpload, csrfToken, serverErrors };
    },
};
</script>
