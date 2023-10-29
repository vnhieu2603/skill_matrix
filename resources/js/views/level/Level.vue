<template>
    <main class="py-5">
        <div class="container">
            <div class="content">
                <h1>Level</h1>
                <div v-if="receivedMsg">
                    <div class="alert alert-success">{{ receivedMsg }}</div>
                </div>
                <router-link :to="'/addLevel'" class="btn btn-primary">Add level</router-link>
                <div v-if="levelList.length">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">Level number</th>
                                <th>Description</th>
                                <th>Color</th>

                                <th width="5%">Sửa</th>
                                <th width="5%">Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="level in levelList" :key="levelList.levelNumber">
                                <td>{{ level.levelNumber }}</td>
                                <td>{{ level.description }}</td>
                                <td :style="'background-color: ' + level.color"> </td>
                                <td>
                                    <router-link :to="'/level/' + level.levelNumber" class="btn btn-warning btn-sm">
                                        Sửa
                                    </router-link>
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-sm"
                                        @click="deleteLevel(level.levelNumber)">Xóa</button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div v-else>
                    <h3>Loading level ....</h3>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import { defineComponent, ref, reactive, toRefs, onMounted } from 'vue';

export default defineComponent({
    data() {
        return {
            receivedMsg: ''
        };
    },
    setup() {
        const levelList = ref([])
        const getLevels = () => {
            axios.get('api/levels')
                .then((response) => {
                    // xử trí khi thành công
                    console.log(response);

                    levelList.value = response.data;
                })
                .catch((error) => {
                    // xử trí khi bị lỗi
                    console.log(error);
                });
        };

        onMounted(() => {
            getLevels();
        });
        return { levelList, getLevels: () => getLevels() }
    },

    created() {
        this.receivedMsg = this.$route.query.message
    },
    methods: {
        reuseFunction() {
            this.getLevels();
        },
        deleteLevel($levelNumber) {
            const deleteLevel = () => {
                axios.delete('api/levels/' + $levelNumber)
                    .then((response) => {
                        // xử trí khi thành công
                        console.log(response);
                        this.receivedMsg = 'Delete level successfully';
                        this.getLevels();
                    })
                    .catch((error) => {
                        // xử trí khi bị lỗi
                        console.log(error);
                    });
            };
            if (window.confirm("bạn có chắc muốn xóa không ??")) {
                deleteLevel();
            }
        }
    }
})
</script>