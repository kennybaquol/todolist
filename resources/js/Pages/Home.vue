<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { nextTick } from 'vue';

const toDoLists = usePage().props.auth.toDoLists;
const mostRecentList = toDoLists.reduce((latest, current) => {
    return new Date(current.updated_at) > new Date(latest.updated_at) ? current : latest;
}, toDoLists[0]);
const items = ref(mostRecentList.items);

const changeFocus = async (index) => {
    await nextTick();

    const inputs = document.querySelectorAll('input[type="text"]');
    if (inputs[index]) {
        inputs[index].focus();
    }
}

const addItem = async (index) => {
    const newItem = {
        value: items.value.length + 1,
        checked: false
    };
    
    items.value.splice(index + 1, 0, newItem);
    changeFocus(index + 1);
}

const deleteItem = (index, event) => {
    if (event.target.value === '' && index > 0) {
        items.value.splice(index, 1);
        changeFocus(index - 1);
    }
}
</script>

<template>
    
    <Head title="Home" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Home</h2>
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
                            />
                            <span class="w-full" :class="{ 'line-through': item.checked }" :for="item.value">
                                <input
                                    type="text"
                                    class="w-full border-0 focus:ring-0"
                                    :class="{ 'line-through': item.checked }"
                                    placeholder="edit me"
                                    @keydown.enter.prevent="addItem(index)"
                                    @keydown.backspace="deleteItem(index, $event)"
                                ></input>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
