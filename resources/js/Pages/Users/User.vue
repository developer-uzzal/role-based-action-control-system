<template>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Users List</h1>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal"
                :disabled="!$page.props.auth.permissions.includes('create-user')">
                Create User
            </button>

            <button class="btn btn-sm btn-info" @click="openAssignRoleModal(user)"
                :disabled="!$page.props.auth.permissions.includes('edit-user')" data-bs-toggle="modal"
                data-bs-target="#assignRoleModal">
                Assign Role
            </button>
        </div>

        <!-- User Table -->
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(user, index) in users" :key="user.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>
                        <span class="badge bg-info me-1" v-for="role in user.roles" :key="role.id">
                            {{ role.name }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-warning me-1" @click="editUser(user)" data-bs-toggle="modal"
                            data-bs-target="#createUserModal"
                            :disabled="!$page.props.auth.permissions.includes('edit-user')">Edit</button>
                        <button class="btn btn-sm btn-danger" @click="deleteUser(user.id)"
                            :disabled="!$page.props.auth.permissions.includes('delete-user')">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Create User Modal -->
        <div class="modal fade" id="createUserModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Create User</h5>
                    </div>
                    <div class="modal-body">
                        <input class="form-control mb-2" placeholder="Name" v-model="form.name" />
                        <input class="form-control mb-2" placeholder="Email" v-model="form.email" />
                        <input class="form-control mb-2" placeholder="Password" type="password"
                            v-model="form.password" />
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" @click="createUser">Create</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit User Modal -->
        <div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Edit User</h5>
                    </div>
                    <div class="modal-body">
                        <input class="form-control mb-2" placeholder="Name" v-model="form.name" />
                        <input class="form-control mb-2" placeholder="Email" v-model="form.email" />
                        <input class="form-control mb-2" placeholder="Password (optional)" type="password"
                            v-model="form.password" />
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" @click="updateUser">Update</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="assignRoleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Assign Role</h5>
                    </div>
                    <div class="modal-body">

                        <label for="" class="form-label"> Select User</label>
                        <select name="" class="form-select mb-2" id="" v-model="selectedUserId" >
                            <option disabled value="">-- Select User --</option>
                            <option v-for="user in users" :value="user.id" :key="user.id">
                                {{ user.name }}
                            </option>
                        </select>
                        
                        <label for="" class="form-label">Select Role</label>
                        <select v-model="selectedRoleId" class="form-select mb-2">
                            <option disabled value="">-- Select Role --</option>
                            <option v-for="role in $page.props.roles" :value="role.id" :key="role.id">
                                {{ role.name }}
                            </option>
                        </select>

                        


                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" @click="assignRole">Assign</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { useForm, usePage, router } from '@inertiajs/vue3'
import { ref, defineProps } from 'vue'
import { Modal } from 'bootstrap'

defineOptions({ layout: AdminLayout })

const props = defineProps({ users: Array })

const form = useForm({
    name: '',
    email: '',
    password: '',
})

const userId = ref(null)

const createUser = () => {
    if (!form.name || !form.email || !form.password) {
        alert('All fields are required!')
        return
    }
    Modal.getInstance('#createUserModal').hide()
    form.post('/user', {
        onSuccess: () => {
            form.reset()
            router.get('/users')
        }
    })
}

const editUser = (user) => {
    userId.value = user.id
    form.name = user.name
    form.email = user.email
    form.password = ''
}

const updateUser = () => {
    if (!userId.value) return alert('No user selected')

    Modal.getInstance('#editUserModal').hide()
    form.put('/user/' + userId.value, {
        onSuccess: () => {
            form.reset()
            router.get('/users')
        }
    })
}

const deleteUser = (id) => {
    if (!confirm('Are you sure you want to delete this user?')) return
    router.delete('/user/' + id, {
        onSuccess: () => router.get('/users')
    })
}

const selectedRoleId = ref(null)
const selectedUserId = ref(null)

const assignRole = () => {

    if (!selectedRoleId.value || !selectedUserId.value) {
        return new Notify({
            title: 'Error',
            text: 'Role or user not selected.',
            status: 'error'
        })
    }

    Modal.getInstance('#assignRoleModal').hide()

    router.post('/role-user-assign', {
        user_id: selectedUserId.value,
        role_id: selectedRoleId.value
    }, {
        onSuccess: () => {
            new Notify({
                status: 'success',
                title: 'Role assigned successfully!',
                autotimeout: 2000,
            })
            router.get('/users')
        },
        onError: () => {
            new Notify({
                status: 'error',
                title: 'Failed to assign role',
                autotimeout: 2000,
            })
        }
    })
}
</script>
