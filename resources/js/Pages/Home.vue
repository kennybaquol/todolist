<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Head, usePage } from '@inertiajs/vue3';
import { ref, nextTick, watch } from 'vue';

const toDoLists = usePage().props.auth.toDoLists;
let currentToDoList = usePage().props.currentToDoList;

// Display the most recently modified list by default
if (!currentToDoList) {
    currentToDoList = toDoLists.reduce((latest, current) => {
        return new Date(current.updated_at) > new Date(latest.updated_at) ? current : latest;
    }, toDoLists[0]);
}

const items = ref(currentToDoList.items);
const headerName = ref(currentToDoList.name);

let saveTimeout = null;

const saveToDoList = () => {
    clearTimeout(saveTimeout);
    saveTimeout = setTimeout(() => {
        const newName = headerName.value || 'Edit me';
        router.patch(`/todolists/${currentToDoList.id}`, { 
            items: items.value,
            name: newName,
        }, {
            onError: (error) => { 
                console.error('Failed to save ToDoList: ', error);
            },
        });
    }, 1000); // 1 second debounce
}

const changeFocus = async (index) => {
    await nextTick();

    const inputs = document.querySelectorAll('.p-6 input[type="text"]');
    console.log(inputs)
    if (inputs[index]) {
        inputs[index].focus();
    }
}

const addItem = async (index) => {
    const newItem = {
        value: items.value.length + 1,
        text: '',
        checked: false,
    }

    items.value.splice(index + 1, 0, newItem);
    saveToDoList();
    changeFocus(index + 1);
}

const deleteItem = (index, event) => {
    if (event.target.value === '' && index > 0) {
        items.value.splice(index, 1);
        saveToDoList();
        changeFocus(index - 1);
    }
}

// Watch for changes to headerName and debounce save
watch(headerName, () => {
    saveToDoList();
});
</script>

<template>    
    <Head title="Home" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <input
                    type="text"
                    v-model="headerName"
                    class="font-semibold text-xl text-gray-800 leading-tight w-full border-0 focus:ring-0"
                    placeholder="Edit me"
                />
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div
                          v-for="(item, index) in items" 
                          :key="item" 
                          class="flex items-center space-x-2 mb-2"
                        >
                            <input
                                type="checkbox"
                                class="w-6 h-6 m-2"
                                v-model="item.checked"
                                :id="item.value"
                                tabindex="-1"
                                @change="saveToDoList"
                            />
                            <span class="w-full" :class="{ 'line-through': item.checked }" :for="item.value">
                                <input
                                    type="text"
                                    class="w-full border-0 focus:ring-0"
                                    :class="{ 'line-through': item.checked }"
                                    v-model="item.text"
                                    placeholder="Edit me"
                                    @input="saveToDoList"
                                    @keydown.enter.prevent="addItem(index)"
                                    @keydown.backspace="deleteItem(index, $event)"
                                />
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
