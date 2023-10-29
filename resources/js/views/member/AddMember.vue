<template>
    <main class="py-5">
        <div class="container">
            <div class="content">
                <h1>Add member</h1>
                <form @submit.prevent="insertMember">
                    <meta name="csrf-token" content="{{ csrf_token() }}">

                    <div class="mb-3">
                        <label for="" :class="{ 'text-danger': errors.MemCode }">Level number</label>
                        <input type="text" class="form-control" name="MemCode" placeholder="Code"
                            :class="{ 'input-danger': errors.MemCode }" v-model="memberToInsert.MemCode" />
                        <div v-if="errors.MemCode">
                            <span style="color: red;">* {{ errors.MemCode[0] }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="" :class="{ 'text-danger': errors.Name }">Description</label>
                        <input type="text" class="form-control" name="Name" placeholder="Name"
                            :class="{ 'input-danger': errors.Name }" v-model="memberToInsert.Name" />
                        <div v-if="errors.Name">
                            <span style="color: red;">* {{ errors.Name[0] }}</span>
                        </div>
                    </div>

                    <button class="btn btn-success" type="submit">Submit</button>
                    <router-link :to="'/member'" class="btn btn-primary">Cancle</router-link>

                </form>

            </div>
        </div>
    </main>
</template>

<script>
import { defineComponent, ref, reactive, toRefs } from 'vue';
import { useRouter } from 'vue-router';
export default defineComponent({

    data() {
        return {

        }
    },
    setup() {
        const errors = ref({});
        const router = useRouter();
        let memberToInsert = reactive({
            MemCode: '',
            Name: '',
        });
        const insertMember = () => {
            axios.post('api/members', memberToInsert)
                .then((response) => {
                    // xử trí khi thành công
                    console.log(response);
                    errors.value = '';

                    router.push({
                        path: '/member',
                        query: { message: "Add member successfully" }
                    })
                })
                .catch((error) => {
                    // xử trí khi bị lỗi
                    console.log(error);
                    errors.value = error.response.data.errors;
                });
        };
        return { memberToInsert, insertMember, errors }
    }
})
</script>

<style lang="css" scoped>
.input-danger {
    border: 1px solid red;
}
</style>