<!-- <template>
        <Head title="Posts" />

<AppLayout>
    <div>
      <h1>User List</h1>
      <ul>
        <li v-for="user in users" :key="user.id">
          {{ user.name }} - {{ user.email }}
          <button @click="deleteUser(user.id)">Delete</button>
          <button @click="makeModerator(user.id)">Make Moderator</button>
        </li>
      </ul>
    </div>
</AppLayout>
  </template> -->

  <template>
    <Head title="User's List" />

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">User's List</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                  
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        
      <table class="w-full text-lg text-left text-black dark:text-gray-400">
                                <thead
                                    class="text-lg text-white uppercase bg-slate-800 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                    
                        
                                        <th scope="col" class="px-6 py-3">#</th>
                                        <th scope="col" class="px-6 py-3">
                                            Name
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Email
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Rank
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Admin
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Action
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Delete
                                        </th>                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user, i in users" :key="user.id" class="text-base bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-2 py-2 text-gray-900 dark:text-white">{{ (i+1) }}</td>
                        <td class="px-2 py-2 text-gray-900 dark:text-white">{{ user.name }}</td>
                        <td class="px-2 py-2 text-gray-900 dark:text-white">{{ user.email }}</td>
                        <td class="px-2 py-2 text-gray-900 dark:text-white">{{ user.power }}</td>
                        <td class="px-2 py-2 text-gray-900 dark:text-white"><SelectInputUser id="power" :options="powers"
                  v-model="user.power"
                  :modelValue ="user.power"
                class="mt-1 block w-3/4"></SelectInputUser>
</td>
                        <td class="px-2 py-2"  v-if="user.power === 9">
                            <RestoreButton @click="makeModerator(user.id,user.name)">
                                <i class="fa-solid fa-edit"></i> Make Moderator
                            </RestoreButton>
                            <RestoreButton @click="makeUser(user.id,user.name)">
                                <i class="fa-solid fa-edit"></i> Make User
                            </RestoreButton>
                        </td>
                        <td class="px-2 py-2"  v-else-if="user.power === 3">
                            <RestoreButton @click="makeAdmin(user.id,user.name)">
                                <i class="fa-solid fa-edit"></i> Make Admin
                            </RestoreButton>
                            <RestoreButton @click="makeUser(user.id,user.name)">
                                <i class="fa-solid fa-edit"></i> Make User
                            </RestoreButton>
                        </td>
                        <td class="px-2 py-2"  v-else>
                            <RestoreButton @click="makeModerator(user.id,user.name)">
                                <i class="fa-solid fa-edit"></i> Make Moderator
                            </RestoreButton>
                            <RestoreButton @click="makeAdmin(user.id,user.name)">
                                <i class="fa-solid fa-edit"></i> Make Admin
                            </RestoreButton>
                        </td>
                        <td class="px-2 py-2">
                            <DangerButton @click="deleteUser(user.id)">
                                <i class="fa-solid fa-trash"></i>Delete
                            </DangerButton>

                        </td>
                    </tr>
                    </tbody>

                </table>

            </div>
        </div>
    </div>
</div>

        </div>

    </AppLayout>
</template>

  
  <script setup>
  import { defineProps } from 'vue';
  import AppLayout from '@/Layouts/AppLayout.vue';
  import DangerButton from '@/Components/DangerButton.vue';
  import RestoreButton from '@/Components/RestoreButton.vue';
  import SelectInputUser from '@/Components/SelectInputUser.vue';
  import { Head, useForm } from '@inertiajs/vue3';
  import Swal from 'sweetalert2';

  
  
//   const props = defineProps({
//     users: {
//       type: Array,
//       required: true
//     }
//   });

  const props = defineProps({
    users: { type: Object },
    powers: { type: Object },
});

console.log(props.users);

  const form = useForm({
    _method: null,
    name: '',
    email: '',
    power: 1,
});

  
  const deleteUser = (userId) => {
    // Make a DELETE request to your server
    // Example using Fetch API:
    fetch(`/users/${userId}`, {
      method: 'DELETE',
    })
    .then(response => {
      // Handle success
      console.log(response);
    })
    .catch(error => {
      // Handle error
      console.error(error);
    });
  };
  
  const makeModerators = (userId) => {
    // Make a POST request to your server to update user's power
    // Example using Fetch API:
    fetch(`/users/${userId}/makeModerator`, {
      method: 'PUT',
    })
    .then(response => {
      // Handle success
      console.log(response);
    })
    .catch(error => {
      // Handle error
      console.error(error);
    });
  };

  const makeModerator = (id, name) => {
    const alerta = Swal.mixin({
        buttonsStyling: true
    });
    alerta.fire({
        title: `Are you sure you want to make ${name} a moderator?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="fa-solid fa-check"></i> Yes, make',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            form.put(route('users.makeModerator', id), {
            preserveState: true,
            onSuccess: () => { ok(`${name} has been made a moderator`); },
            onError: (errors) => { console.error('Error making user moderator:', errors); },
        });

        }
    });
}
const ok = (message) => {
    form.reset();
     Swal.fire({ title: message, icon: 'success' });
}
  </script>
  