import { reactive } from "vue";

export default function useFormValidation() {
    const form = reactive({
        name: "",
        email: "",
        phone: "",
        message: "",
        street: "",
        state: "",
        zip: "",
        country: "",
        images: [],
        files: [],
    });

    const errors = reactive({});

    const allowedImageTypes = ["image/jpeg", "image/jpg"];
    const allowedFileTypes = ["application/pdf"];

    const validate = () => {
        errors.name = !form.name ? "Name is required." : form.name.length < 2 || form.name.length > 10 ? "Name must be 2-10 characters." : "";
        errors.email = !form.email ? "Email is required." : (!form.email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/) || form.email.includes("gmail.com")) ? "Invalid email or Gmail not allowed." : "";
        errors.phone = !form.phone ? "Phone is required." : !form.phone.match(/^\+\d{1,3}\s?\d{7,}$/) ? "Invalid phone number." : "";
        errors.message = !form.message ? "Message is required." : form.message.length < 10 ? "Message must be at least 10 characters." : "";
        errors.street = !form.street ? "Street is required." : "";
        errors.state = !form.state ? "State is required." : "";
        errors.zip = !form.zip ? "ZIP is required." : "";
        errors.country = !form.country ? "Country is required." : "";

        // File Validation
        errors.images = form.images.some(file => !allowedImageTypes.includes(file.type)) ? "Only JPG images are allowed." : "";
        errors.files = form.files.some(file => !allowedFileTypes.includes(file.type)) ? "Only PDF files are allowed." : "";

        return Object.values(errors).every((err) => err === "");
    };

    return { form, errors, validate };
}
