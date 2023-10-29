<template>
    <div>
        <main class="py-5">
            <div class="container">
                <div class="content">
                    <h1>Level {{ $route.params.levelNumber }} detail</h1>
                    <form @submit.prevent="updateLevels">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <div class="mb-3">
                            <label for="">Level number</label>
                            <input type="text" class="form-control" name="levelNumber" placeholder="level number"
                                :class="{ 'input-danger': errors.levelNumber }" v-model="level.levelNumber" />
                            <div v-if="errors.levelNumber">
                                <span style="color: red;">* {{ errors.levelNumber[0] }}</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="">Level description</label>
                            <input type="text" class="form-control" name="description" placeholder="level description"
                                :class="{ 'input-danger': errors.description }" v-model="level.description" />
                            <div v-if="errors.description">
                                <span style="color: red;">* {{ errors.description[0] }}</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="">Color</label>
                            <input type="color" class="form-control" name="color" placeholder="level number"
                                :class="{ 'input-danger': errors.color }" v-model="level.color" />
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
    </div>
</template>

<script>
import { defineComponent, ref, } from 'vue';
import { useRoute } from 'vue-router';

import { useRouter } from 'vue-router';
export default defineComponent({
    data() {
        return {
        }
    },

    setup() {
        const errors = ref({});
        const route = useRoute();
        const router = useRouter();
        const levelNumber = route.params.levelNumber;
        const level = ref({});
        const getLevelDetail = () => {
            axios.get(`http://127.0.0.1:8000/api/levels/${levelNumber}`)
                .then((response) => {
                    // xử trí khi thành công
                    console.log(response);
                    level.value = response.data;
                    console.log("level: " + level.value.levelNumber)
                })
                .catch((error) => {
                    // xử trí khi bị lỗi
                    console.log(error);
                });
        };
        getLevelDetail();

        const updateLevels = () => {
            axios.post(`http://127.0.0.1:8000/api/levels/${levelNumber}`, level.value)
                .then((response) => {
                    // xử trí khi thành công
                    console.log(response);
                    errors.value = '';

                    router.push({
                        path: '/level',
                        query: { message: "update level successfully" }
                    })
                })
                .catch((error) => {
                    // xử trí khi bị lỗi
                    console.log(error);
                    errors.value = error.response.data.errors;
                });
        };

        return { level, errors, updateLevels }
    },
})
</script>

<style>
.input-danger {
    border: 1px solid red;
}
</style>