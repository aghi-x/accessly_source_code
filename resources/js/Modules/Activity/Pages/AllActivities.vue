<script setup>
import { computed } from 'vue'
import { usePage, router } from '@inertiajs/vue3'
import LeftSidebar from '@/Components/LeftSidebar.vue';
import MenuButton from '@/Components/MenuButton.vue';
import ListOfActivities from '../Components/ListOfActivities.vue';
import { useStore } from 'vuex'
import { Head } from '@inertiajs/vue3'

const store = useStore()
const sidebarOpen = computed(() => store.state.sidebarOpen)
const activities = computed(() => page.props.activities.data)
const links = computed(() => page.props.activities.links)
const page = usePage()

</script>

<template>
<div>
    <Head title="Activities" />


<div class="grid grid-cols-12 gap-4">

<!-- Left column (3/12) -->
<div  v-if="sidebarOpen" class="col-span-12 md:col-span-3 lg:col-span-2 xl:col-span-2">

<LeftSidebar  @close-sidebar="sidebarOpen = false"/>

</div>

<!-- Right column (9/12) -->
<div
:class="[
'bg-base-100 p-4 transition-all duration-300',
sidebarOpen
? 'col-span-12 md:col-span-9 lg:col-span-10 xl:col-span-10'
: 'col-span-12'
]"
>
         <MenuButton />

<!-- Title -->

<ListOfActivities :activities="activities" :links="links"/>


</div>

</div>
</div>

</template>

<style scoped>
/* Optional styling */
</style>
