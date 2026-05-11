<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps({
    user: Object,
    orders: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <AppLayout>
        <Head title="Pesanan" />

        <section class="max-w-7xl mx-auto px-4 py-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Pesanan Saya</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Riwayat pesanan untuk {{ user?.name ?? "akun Anda" }}.
                </p>
            </div>

            <div v-if="orders.length" class="space-y-4">
                <div
                    v-for="order in orders"
                    :key="order.id"
                    class="card flex items-center justify-between gap-4"
                >
                    <div>
                        <p class="font-semibold text-gray-900">
                            Pesanan #{{ order.id }}
                        </p>
                        <p class="text-sm text-gray-500">
                            Status: {{ order.status ?? "diproses" }}
                        </p>
                    </div>
                    <Link
                        :href="`/orders/${order.id}`"
                        class="btn-secondary text-sm"
                    >
                        Detail
                    </Link>
                </div>
            </div>

            <div v-else class="card text-center">
                <h2 class="text-lg font-semibold text-gray-900">
                    Belum ada pesanan
                </h2>
                <p class="text-sm text-gray-500 mt-2">
                    Pesanan yang sudah dibuat akan tampil di halaman ini.
                </p>
                <Link href="/" class="btn-primary inline-flex mt-5">
                    Kembali ke Beranda
                </Link>
            </div>
        </section>
    </AppLayout>
</template>
