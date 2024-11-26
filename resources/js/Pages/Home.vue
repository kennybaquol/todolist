<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const checkboxes = ref([{ value: 0, checked: false }, { value: 1, checked: false }]);

const addCheckbox = async (index) => {
    const newCheckbox = {
        value: checkboxes.value.length + 1,
        checked: false
    };
    
    checkboxes.value.splice(index + 1, 0, newCheckbox);
}

const deleteCheckbox = (checkboxId) => {
    // this needs to be written
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
                          v-for="(checkbox, index) in checkboxes" 
                          :key="checkbox" 
                          class="flex items-center space-x-2 mb-2"
                        >
                            <input type="checkbox" class="w-6 h-6 m-2" v-model="checkbox.checked" :id="checkbox.value" />
                            <span class="w-full" :class="{ 'line-through': checkbox.checked }" :for="checkbox.value">
                                <input
                                    type="text"
                                    class="w-full border-0 focus:ring-0"
                                    :class="{ 'line-through': checkbox.checked }"
                                    placeholder="edit me"
                                    @keydown.enter.prevent="addCheckbox(index)"
                                ></input>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
