<template>
    <main class="py-5">
        <div class="container">
            <div class="content">
                <h1>Add skill</h1>
                <form @submit.prevent="insertSkill">
                    <meta name="csrf-token" content="{{ csrf_token() }}">

                    <div class="mb-3">
                        <label for="" :class="{ 'text-danger': errors.Id }">Skill Id</label>
                        <input type="text" class="form-control" name="Id" placeholder="Id"
                            :class="{ 'input-danger': errors.Id }" v-model="skillToInsert.Id" />
                        <div v-if="errors.Id">
                            <span style="color: red;">* {{ errors.Id[0] }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="" :class="{ 'text-danger': errors.Name }">Description</label>
                        <input type="text" class="form-control" name="Name" placeholder="Name"
                            :class="{ 'input-danger': errors.Name }" v-model="skillToInsert.Name" />
                        <div v-if="errors.Name">
                            <span style="color: red;">* {{ errors.Name[0] }}</span>
                        </div>
                    </div>

                    <button class="btn btn-success" type="submit">Submit</button>
                    <router-link :to="'/skill'" class="btn btn-primary">Cancle</router-link>

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
        let skillToInsert = reactive({
            MemCode: '',
            Name: '',
        });
        const insertSkill = () => {
            axios.post('api/skills', skillToInsert)
                .then((response) => {
                    // xử trí khi thành công
                    console.log(response);
                    errors.value = '';

                    router.push({
                        path: '/skill',
                        query: { message: "Add skill successfully" }
                    })
                })
                .catch((error) => {
                    // xử trí khi bị lỗi
                    console.log(error);
                    errors.value = error.response.data.errors;
                });
        };
        return { skillToInsert, insertSkill, errors }
    }
})
</script>

<style lang="css" scoped>
.input-danger {
    border: 1px solid red;
}
</style>