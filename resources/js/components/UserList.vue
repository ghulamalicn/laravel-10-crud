<template>
    <div>
        <!-- Add/Edit user button -->
        <table class="table">
            <thead>
                <tr>
                    <th>id</th>
                    <th><a href="{{ route('users.index', ['sort' => 'user_name', 'sortOrder' => ($sortField == 'user_name' && $sortOrder == 'asc') ? 'desc' : 'asc', 'search' => $search]) }}">User Name</a></th>
                    <th><a href="{{ route('users.index', ['sort' => 'first_name', 'sortOrder' => ($sortField == 'first_name' && $sortOrder == 'asc') ? 'desc' : 'asc', 'search' => $search]) }}">First Name</a></th>
                    <th><a href="{{ route('users.index', ['sort' => 'last_name', 'sortOrder' => ($sortField == 'last_name' && $sortOrder == 'asc') ? 'desc' : 'asc', 'search' => $search]) }}">Last Name</a></th>
                    <th><a href="{{ route('users.index', ['sort' => 'email', 'sortOrder' => ($sortField == 'email' && $sortOrder == 'asc') ? 'desc' : 'asc', 'search' => $search]) }}">Email</a></th>
                    <th><a href="{{ route('users.index', ['sort' => 'phone', 'sortOrder' => ($sortField == 'phone' && $sortOrder == 'asc') ? 'desc' : 'asc', 'search' => $search]) }}">Phone</a></th>
                    <th><a href="{{ route('users.index', ['sort' => 'dob', 'sortOrder' => ($sortField == 'dob' && $sortOrder == 'asc') ? 'desc' : 'asc', 'search' => $search]) }}">Date Of Birth</a></th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <tr v-for="user in usersList" :key="user.id">
                <td>{{ user.id }}</td>
                <td>{{ user.user_name }}</td>
                <td>{{ user.first_name }}</td>
                <td>{{ user.last_name }}</td>
                <td>{{ user.phone }}</td>
                <td>{{ user.dob }}</td>
                <td>{{ user.email }}</td>
                <!-- Actions -->
                <td>
                    <button @click="viewUser(user.id)" class="btn btn-info">View</button>
                    <button @click="editUser(user.id)" class="btn btn-warning">Edit</button>
                    <button @click="deleteUser(user.id)" class="btn btn-danger">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
        <!-- Show success or error message -->
        <div v-if="message" class="alert" :class="messageType">
            {{ message }}
        </div>
    </div>
  </template>

  <script>
    // Extract CSRF token from the meta tag
    const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
    export default {
        props: {
        users: Array,
        sortField: String,
        sortOrder: String,
        search: String,
        },
        data() {
            return {
                usersList: [],
                message: '', // To store success or error message
                messageType: '', // To store message type (success or error)
            };
        },
        created() {
            // Assign the 'users' prop to 'usersList' when the component is created
            this.usersList = this.users.data;
        },
        methods: {
            viewUser(userId) {
                // Implement logic to navigate to the user view page
                // You can use the router or window.location.href
                console.log('View User:', userId);
            },
            editUser(userId) {
                // Implement logic to navigate to the user edit page
                // You can use the router or window.location.href
                console.log('Edit User:', userId);
            },
            deleteUser(userId) {
                // Extract CSRF token from the meta tag
                // Call your delete function with the user ID
                this.message = '';
                this.messageType = '';
                this.deleteUserApi(userId);
            },
            deleteUserApi(userId) {
                axios
                .delete(`/users/${userId}`, { headers: { 'X-CSRF-TOKEN': csrfToken } })
                .then((response) => {
                    if (response.data.success) {
                        const index = this.usersList.findIndex((user) => user.id === response.data.deletedUserId);
                        if (index !== -1) {
                            this.usersList.splice(index, 1);
                            // Set success message
                        }
                        this.message = 'User deleted successfully';
                        this.messageType = 'alert-success';
                        console.log("success message");
                        console.log(response.data.message);
                        console.log("succ messageType");
                        console.log(this.messageType);
                    } else {
                        // Set error message
                        this.message = 'Failed to delete user';
                        this.messageType = 'alert-danger';
                        console.log("else success message");
                        console.log(response.data.message);
                        console.log("succ messageType");
                        console.log(this.messageType);
                    }
                })
                .catch((error) => {
                    // Set error message
                    this.message = 'An error occurred';
                    this.messageType = 'alert-danger';
                    console.error(error);
                });
            },
        },
    };
  </script>
