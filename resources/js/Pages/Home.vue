<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { nextTick } from 'vue'

const checkboxes = ref([{ value: 0, checked: false }, { value: 1, checked: false }]);

const changeFocus = async (index) => {
    await nextTick();

    const inputs = document.querySelectorAll('input[type="text"]');
    if (inputs[index]) {
        inputs[index].focus();
    }
}

const addCheckbox = async (index) => {
    const newCheckbox = {
        value: checkboxes.value.length + 1,
        checked: false
    };
    
    checkboxes.value.splice(index + 1, 0, newCheckbox);
    changeFocus(index + 1);
}

const deleteCheckbox = (index, event) => {
    if (event.target.value === '' && index > 0) {
        checkboxes.value.splice(index, 1);
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
                          v-for="(checkbox, index) in checkboxes" 
                          :key="checkbox" 
                          class="flex items-center space-x-2 mb-2"
                        >
                            <input
                                type="checkbox"
                                class="w-6 h-6 m-2"
                                v-model="checkbox.checked"
                                :id="checkbox.value" 
                                tabindex="-1"
                            />
                            <span class="w-full" :class="{ 'line-through': checkbox.checked }" :for="checkbox.value">
                                <input
                                    type="text"
                                    class="w-full border-0 focus:ring-0"
                                    :class="{ 'line-through': checkbox.checked }"
                                    placeholder="edit me"
                                    @keydown.enter.prevent="addCheckbox(index)"
                                    @keydown.backspace="deleteCheckbox(index, $event)"
                                ></input>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
