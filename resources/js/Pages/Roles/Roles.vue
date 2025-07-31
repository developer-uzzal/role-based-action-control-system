<template>
  <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
      <h1 class="mb-4">Roles</h1>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"
        :disabled="!$page.props.auth.permissions.includes('create-user')">
        Create Role
      </button>

      <!-- Modal -->
      <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Create Role</h1>
            </div>
            <div class="modal-body">

              <input type="text" class="form-control" placeholder="Role Name" v-model="formRole.name">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" @click="submitCreateRole">Save changes</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Role</h1>
            </div>
            <div class="modal-body">

              <input type="text" class="form-control" placeholder="Role Name" v-model="roleEdit.name">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" @click="submitEditRole">Save changes</button>
            </div>
          </div>
        </div>
      </div>



    </div>



    <div v-if="roles.length">
      <table class="table table-bordered table-hover">
        <thead class="table-dark">
          <tr>
            <th scope="col">Role Name</th>
            <th scope="col">Permissions</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="role in roles" :key="role.id">
            <td>{{ role.name }}</td>
            <td>
              <ul class="list-unstyled mb-0">
                <li v-if="role.permissions && role.permissions.length" v-for="permission in role.permissions"
                  :key="permission.id" class="badge bg-primary me-1 mb-1">
                  {{ permission.name }}
                </li>
                <li v-else><em>No permissions assigned.</em></li>
              </ul>
            </td>
            <td>
              <button type="button" @click="editRoleClick(role.id, role.name)" class="btn btn-sm btn-primary me-2"
                data-bs-toggle="modal" data-bs-target="#editModal" :disabled="!$page.props.auth.permissions.includes('edit-user')">Edit</button>
              <button type="button" @click="deleteRole(role.id)" class="btn btn-sm btn-danger" :disabled="!$page.props.auth.permissions.includes('delete-user')">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-else>
      <p>No roles found.</p>
    </div>

    <hr />

    <h2>All Unique Permissions</h2>

    <button type="button" class="btn btn btn-warning me-2 mb-2" data-bs-toggle="modal"
      data-bs-target="#permissionModal" :disabled="!$page.props.auth.permissions.includes('create-user')">
      Assign Permission
    </button>


    <ul class="list-group">
      <li v-for="perm in permissions" :key="perm" class="list-group-item">
        {{ perm }}
      </li>
    </ul>

    <div class="modal fade" id="permissionModal" tabindex="-1" aria-labelledby="permissionModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="permissionModalLabel">Assign Permissions</h5>
          </div>
          <div class="modal-body">

            <div class="mb-3">
              <select name="roles" id="" class="form-select" v-model="selectedRoleId">
                <option value="" disabled>Select Role</option>
                <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.name }}</option>
              </select>
            </div>

            <div v-if="permissions.length">

              <div class="form-check" v-for="perm in permissions" :key="perm">
                <input class="form-check-input" type="checkbox" :value="perm" v-model="assignedPermissions">
                <label class="form-check-label">{{ perm }}</label>
              </div>
            </div>
            <div v-else>
              <em>No permissions available.</em>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" @click="submitAssignedPermissions">Save</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
import { defineProps, ref } from 'vue'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { router, usePage } from '@inertiajs/vue3'


const page = usePage()

import { useForm } from '@inertiajs/vue3'
import { Modal } from 'bootstrap'


defineOptions({
  layout: AdminLayout
})

const props = defineProps({
  roles: Array,
  permissions: Array
})

const formRole = useForm({
  name: ''
})

const submitCreateRole = () => {

  if (formRole.name == '') {
    new Notify({
      title: 'Error',
      text: 'Role name is required',
      status: 'error'
    })

    return
  } else {
    Modal.getInstance('#createModal').hide();
    formRole.post('/role-create', {
      onSuccess: () => {
        if (page.props.flash.success) {
          new Notify({
            status: 'success',
            title: page.props.flash.success.message,
            autotimeout: 2000,
          })
          formRole.name = '';

          router.get("/roles");



        } else if (page.props.flash.error) {
          new Notify({
            status: 'error',
            title: page.props.flash.error.message,
            autotimeout: 2000,
          })
        }
      }


    })
  }
}


const deleteRole = (id) => {
  if (confirm('Are you sure you want to delete this role?')) {
    router.delete('/role-delete/' + id, {
      onSuccess: () => {
        if (page.props.flash.success) {
          new Notify({
            status: 'success',
            title: page.props.flash.success.message,
            autotimeout: 2000,
          })
        } else if (page.props.flash.error) {
          new Notify({
            status: 'error',
            title: page.props.flash.error.message,
            autotimeout: 2000,
          })
        }
        router.get("/roles");
      },

      onError: () => {
        new Notify({
          title: 'Error',
          text: 'Delete failed',
          status: 'error'
        })
      }
    })

  }


}

const roleEdit = useForm({
  name: ''
})

const roleId = ref(0)

const editRoleClick = (id, name) => {

  roleId.value = id
  roleEdit.name = name

}

const submitEditRole = () => {

  if (roleEdit.name == '') {
    new Notify({
      title: 'Error',
      text: 'Role name is required',
      status: 'error'
    })

    return
  } else if (roleId.value == 0) {
    new Notify({
      title: 'Error',
      text: 'Role id is required',
      status: 'error'
    })
  } else {
    Modal.getInstance('#editModal').hide();
    roleEdit.put('/role-update/' + roleId.value, {
      onSuccess: () => {
        if (page.props.flash.success) {
          new Notify({
            status: 'success',
            title: page.props.flash.success.message,
            autotimeout: 2000,
          })
          roleEdit.name = '';

          router.get("/roles");



        } else if (page.props.flash.error) {
          new Notify({
            status: 'error',
            title: page.props.flash.error.message,
            autotimeout: 2000,
          })
        }
      }


    })
  }
}




const selectedRoleId = ref(null)

const assignedPermissions = ref([])



const submitAssignedPermissions = () => {


  if (!selectedRoleId.value) {
    return new Notify({
      title: 'Error',
      text: 'Role not selected.',
      status: 'error'
    })
  }

  Modal.getInstance('#permissionModal').hide()

  router.post('/role-permission-assign', {
    role_id: selectedRoleId.value,
    items: assignedPermissions.value
  }, {
    onSuccess: () => {
      new Notify({
        status: 'success',
        title: 'Permissions assigned successfully!',
        autotimeout: 2000,
      })
      router.get('/roles')
    },
    onError: () => {
      new Notify({
        status: 'error',
        title: 'Failed to assign permissions',
        autotimeout: 2000,
      })
    }
  })
}
</script>
