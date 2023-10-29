<template>
    <main class="py-5">
        <div class="container">
            <div class="content">
                <h1>Skill</h1>
                <div v-if="receivedMsg">
                    <div class="alert alert-success">{{ receivedMsg }}</div>
                </div>
                <router-link :to="'/addSkill'" class="btn btn-primary">Add skill</router-link>
                <router-link :to="'/changeSkillPosition'" class="btn btn-secondary">Change position</router-link>

                <div v-if="skillList.length">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">STT</th>
                                <th>Code</th>
                                <th>Tên</th>

                                <th width="5%">Sửa</th>
                                <th width="5%">Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="skill in skillList" :key="skill.id">
                                <td>{{ skill.Position }}</td>
                                <td>{{ skill.Id }}</td>
                                <td>{{ skill.Name }}</td>

                                <td>
                                    <router-link :to="''" class="btn btn-warning btn-sm">
                                        Sửa
                                    </router-link>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-danger btn-sm"
                                        onclick="return confirm('You want to delete ??')">Xóa</a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div v-else>
                    <h3>Loading skill ....</h3>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import { defineComponent, ref, reactive, toRefs } from 'vue';

export default defineComponent({
    data() {
        return {
            receivedMsg: '',

        };
    },
    created() {
        this.receivedMsg = this.$route.query.message
    },
    setup() {
        const skillList = ref([])
        const getSkills = () => {
            axios.get('api/skills')
                .then((response) => {
                    // xử trí khi thành công
                    console.log(response);

                    skillList.value = response.data;
                })
                .catch((error) => {
                    // xử trí khi bị lỗi
                    console.log(error);
                });
        };
        getSkills();
        return { skillList }
    }
})
</script>

<style scoped>
.btn {
    margin-right: 5px;
}
</style>