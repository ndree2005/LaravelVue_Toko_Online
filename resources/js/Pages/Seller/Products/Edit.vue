<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm, Link, Head } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({ product: Object, categories: Array });

const form = useForm({
    _method: "put",
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
    const file = e.target.files[0];

    if (!file) {
        form.image = null;
        return;
    }

    form.image = file;
    previewUrl.value = URL.createObjectURL(file);
};

// Gunakan POST + _method=put agar upload file tetap terbaca oleh Laravel.
const submit = () =>
    form.post(route("seller.products.update", props.product.id), {
        forceFormData: true,
    });
</script>

<template>
    <AppLayout>
        <Head title="Edit Produk" />

        <div class="max-w-3xl mx-auto px-4 py-8">
            <div class="flex items-center gap-3 mb-6">
                <Link
                    :href="route('seller.products.index')"
                    class="text-gray-400 hover:text-gray-600"
                >
                    &lt; Kembali
                </Link>

                <h1 class="text-2xl font-bold">Edit Produk</h1>
            </div>

            <div class="card">
                <form @submit.prevent="submit" class="space-y-6">
                    <div>
                        <label class="label"> Nama Produk * </label>

                        <input
                            v-model="form.name"
                            type="text"
                            class="input"
                            :class="form.errors.name && 'border-red-500'"
                        />

                        <p
                            v-if="form.errors.name"
                            class="text-red-600 text-sm mt-1"
                        >
                            {{ form.errors.name }}
                        </p>
                    </div>

                    <div>
                        <label class="label"> Deskripsi </label>

                        <textarea
                            v-model="form.description"
                            rows="4"
                            class="input"
                        />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label"> Harga (Rp) * </label>

                            <input
                                v-model.number="form.price"
                                type="number"
                                min="0"
                                class="input"
                                :class="form.errors.price && 'border-red-500'"
                            />

                            <p
                                v-if="form.errors.price"
                                class="text-red-600 text-sm mt-1"
                            >
                                {{ form.errors.price }}
                            </p>
                        </div>

                        <div>
                            <label class="label"> Stok * </label>

                            <input
                                v-model.number="form.stock"
                                type="number"
                                min="0"
                                class="input"
                                :class="form.errors.stock && 'border-red-500'"
                            />

                            <p
                                v-if="form.errors.stock"
                                class="text-red-600 text-sm mt-1"
                            >
                                {{ form.errors.stock }}
                            </p>
                        </div>
                    </div>

                    <div>
                        <label class="label"> Status Produk </label>

                        <select v-model="form.status" class="input">
                            <option value="draft">Draft (belum tampil)</option>
                            <option value="active">
                                Aktif (tampil di katalog)
                            </option>
                            <option value="inactive">Nonaktif</option>
                        </select>

                        <p
                            v-if="form.errors.status"
                            class="text-red-600 text-sm mt-1"
                        >
                            {{ form.errors.status }}
                        </p>
                    </div>

                    <div>
                        <label class="label"> Foto Produk </label>

                        <div class="flex items-start gap-4">
                            <div
                                v-if="previewUrl"
                                class="w-32 h-32 rounded-xl overflow-hidden border"
                            >
                                <img
                                    :src="previewUrl"
                                    class="w-full h-full object-cover"
                                    alt="Preview produk"
                                />
                            </div>

                            <div>
                                <input
                                    type="file"
                                    accept="image/*"
                                    @change="onFileChange"
                                    class="block text-sm text-gray-500"
                                />

                                <p class="text-xs text-gray-400 mt-1">
                                    Kosongkan jika tidak ingin mengganti foto.
                                    JPG, PNG, WebP. Maks 2MB.
                                </p>

                                <p
                                    v-if="form.errors.image"
                                    class="text-red-600 text-sm mt-1"
                                >
                                    {{ form.errors.image }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="label"> Kategori </label>

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                            <label
                                v-for="cat in categories"
                                :key="cat.id"
                                class="flex items-center gap-2 p-2 rounded-lg border cursor-pointer hover:bg-orange-50 transition-colors"
                                :class="
                                    form.category_ids.includes(cat.id) &&
                                    'border-orange-500 bg-orange-50'
                                "
                            >
                                <input
                                    type="checkbox"
                                    :value="cat.id"
                                    v-model="form.category_ids"
                                    class="text-orange-600"
                                />

                                <span> {{ cat.icon }} {{ cat.name }} </span>
                            </label>
                        </div>

                        <p
                            v-if="form.errors.category_ids"
                            class="text-red-600 text-sm mt-1"
                        >
                            {{ form.errors.category_ids }}
                        </p>
                    </div>

                    <div class="flex gap-3">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="btn-primary"
                        >
                            {{
                                form.processing
                                    ? "Menyimpan..."
                                    : "Simpan Perubahan"
                            }}
                        </button>

                        <Link
                            :href="route('seller.products.index')"
                            class="btn-secondary"
                        >
                            Batal
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
