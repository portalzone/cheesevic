<script setup>
import { onMounted, ref, defineProps, defineEmits, defineModel, defineExpose } from 'vue';

defineProps(['modalValue', 'options']);

defineEmits(['update:modalValue']);

const model = defineModel({
    type: Number,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <select class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
            v-model="model"
            @change="$emit('update:modalValue', model)"
            ref="input">
        <option v-for="op in options" :key="op.id" :value="op.post">{{ op.name }}</option>
    </select> 
</template>