<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm, Link, Head } from "@inertiajs/vue3";
import { ref } from "vue";
const props = defineProps({ product: Object, categories: Array });
const form = useForm({
    name: props.product.name,
    description: props.product.description || "",
    price: props.product.price,
    stock: props.product.stock,
    status: props.product.status,
    image: null, // null = tidak ganti foto
    // Isi dengan ID kategori yang sudah dipilih sebelumnya
    category_ids: props.product.categories.map((c) => c.id),
});
// Foto lama tampil sebagai preview awal
const previewUrl = ref(
    props.product.image ? "/storage/" + props.product.image : null,
);
const onFileChange = (e) => {
    form.image = e.target.files[0];
    previewUrl.value = URL.createObjectURL(form.image);
};
// Gunakan POST + _method:PUT (karena browser tidak bisa PUT + file)
// Inertia menangani ini otomatis ketika forceFormData: true
const submit = () =>
    form.post(route("seller.products.update", props.product.id), {
        forceFormData: true,
    });
</script>
