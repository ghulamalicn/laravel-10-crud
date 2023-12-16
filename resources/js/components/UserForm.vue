<template>
    <form @submit.prevent="submitForm">
        <div class="form-group">
            <label for="user_name">User Name</label>
            <input v-model="formData.user_name" type="text" name="user_name" class="form-control" :class="{ 'is-invalid': errors.user_name }">
            <span v-if="errors.user_name" class="invalid-feedback" role="alert">{{ errors.user_name }}</span>
        </div>

        <div class="form-group">
            <label for="first_name">First Name</label>
            <input v-model="formData.first_name" type="text" name="first_name" class="form-control" :class="{ 'is-invalid': errors.first_name }">
            <span v-if="errors.first_name" class="invalid-feedback" role="alert">{{ errors.first_name }}</span>
        </div>

        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input v-model="formData.last_name" type="text" name="last_name" class="form-control" :class="{ 'is-invalid': errors.last_name }">
            <span v-if="errors.last_name" class="invalid-feedback" role="alert">{{ errors.last_name }}</span>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input v-model="formData.email" type="email" name="email" class="form-control" :class="{ 'is-invalid': errors.email }">
            <span v-if="errors.email" class="invalid-feedback" role="alert">{{ errors.email }}</span>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input v-model="formData.phone" type="text" name="phone" class="form-control" :class="{ 'is-invalid': errors.phone }">
            <span v-if="errors.phone" class="invalid-feedback" role="alert">{{ errors.phone }}</span>
        </div>

        <div class="form-group">
            <label for="dob">DOB</label>
            <input v-model="formData.dob" type="text" name="dob" class="form-control" :class="{ 'is-invalid': errors.dob }">
            <span v-if="errors.dob" class="invalid-feedback" role="alert">{{ errors.dob }}</span>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input v-model="formData.password" type="password" name="password" class="form-control" :class="{ 'is-invalid': errors.password }">
            <span v-if="errors.password" class="invalid-feedback" role="alert">{{ errors.password }}</span>
        </div>

        <button type="submit" class="btn btn-success mb-5">Create User</button>
    </form>
</template>

<script>
    const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
    export default {
        data() {
            return {
                formData: {
                    user_name: '',
                    first_name: '',
                    last_name: '',
                    email: '',
                    phone: '',
                    dob: '',
                    password: '',
                },
                errors: {},
            };
        },
        methods: {
            submitForm() {
                // Clear previous errors
                this.errors = {};

                // Make an Axios request to the server
                axios.post('/users', this.formData , { headers: {'X-CSRF-TOKEN': csrfToken}})
                    .then(response => {
                        // Handle success, e.g., redirect or show a success message
                        window.location.href = '/users';
                    })
                    .catch(error => {
                        // Handle validation errors
                        if (error.response.status === 422) {
                            const errorData = error.response.data.errors;
                            // Loop through each field and extract the first error message
                            Object.keys(errorData).forEach(field => {
                                this.errors[field] = Array.isArray(errorData[field]) ? errorData[field][0] : errorData[field];
                            });
                        } else {
                            // Handle other types of errors
                        }
                    });
            },
        },
    };
</script>
