<template>
    <main class="py-5">
        <div class="container">
            <div class="content">
                <h1>Member</h1>
                <div v-if="receivedMsg">
                    <div class="alert alert-success">{{ receivedMsg }}</div>
                </div>
                <router-link :to="'/addMember'" class="btn btn-primary">Add member</router-link>
                <div v-if="memberList.length">
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
                            <tr v-for="(member, index) in memberList" :key="member.MemCode">
                                <td>{{ index + 1 }}</td>
                                <td>{{ member.MemCode }}</td>
                                <td>{{ member.Name }}</td>

                                <td>
                                    <router-link :to="'/member/' + member.MemCode" class="btn btn-warning btn-sm">
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
                    <h3>Loading member ....</h3>
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
        const memberList = ref([])
        const getMembers = () => {
            axios.get('api/members')
                .then((response) => {
                    // xử trí khi thành công
                    console.log(response);

                    memberList.value = response.data;
                })
                .catch((error) => {
                    // xử trí khi bị lỗi
                    console.log(error);
                });
        };
        getMembers();
        return { memberList }
    }
})
</script>