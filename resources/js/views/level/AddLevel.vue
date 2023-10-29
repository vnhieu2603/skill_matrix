<template>
    <main class="py-5">
        <div class="container">
            <div class="content">
                <h1>Add level</h1>
                <form @submit.prevent="insertLevels">
                    <meta name="csrf-token" content="{{ csrf_token() }}">

                    <div class="mb-3">
                        <label for="" :class="{ 'text-danger': errors.levelNumber }">Level number</label>
                        <input type="text" class="form-control" name="levelNumber" placeholder="level number"
                            :class="{ 'input-danger': errors.levelNumber }" v-model="levelsToInsert.levelNumber" />
                        <div v-if="errors.levelNumber">
                            <span style="color: red;">* {{ errors.levelNumber[0] }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="" :class="{ 'text-danger': errors.description }">Description</label>
                        <input type="text" class="form-control" name="description" placeholder="description"
                            :class="{ 'input-danger': errors.description }" v-model="levelsToInsert.description" />
                        <div v-if="errors.description">
                            <span style="color: red;">* {{ errors.description[0] }}</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="" :class="{ 'text-danger': errors.color }">Color</label>
                        <input type="color" class="form-control" name="color" placeholder="color"
                            :class="{ 'input-danger': errors.color }" v-model="levelsToInsert.color" />
                        <div v-if="errors.color">
                            <span style="color: red;">* {{ errors.color[0] }}</span>
                        </div>
                    </div>
                    <button class="btn btn-success" type="submit">Submit</button>
                    <router-link :to="'/level'" class="btn btn-primary">Cancle</router-link>

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
        let levelsToInsert = reactive({
            levelNumber: '',
            description: '',
            color: '#ffffff',
        });
        const insertLevels = () => {
            axios.post('api/levels', levelsToInsert)
                .then((response) => {
                    // xử trí khi thành công
                    console.log(response);
                    errors.value = '';

                    router.push({
                        path: '/level',
                        query: { message: "Add level successfully" }
                    })
                })
                .catch((error) => {
                    // xử trí khi bị lỗi
                    console.log(error);
                    errors.value = error.response.data.errors;
                });
        };
        return { levelsToInsert, insertLevels, errors }
    }
})
</script>

<style lang="css" scoped>
.input-danger {
    border: 1px solid red;
}
</style>