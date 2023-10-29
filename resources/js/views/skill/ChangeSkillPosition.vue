<template>
    <div>
        <main class="py-5">
            <div class="container">
                <div class="content">
                    <h1>Change position</h1>

                    <div v-if="skillList.length">

                        <div class="drop-zone" @dragenter.prevent @dragover.prevent>
                            <div v-for="skill in skillList" :key="skill.id" draggable="true" class="drag-el"
                                @dragstart="startDrag($event, skill)" @drop="onDrop($event, skill)">
                                {{ skill.Position }}, {{ skill.Name }}
                            </div>

                        </div>
                    </div>
                    <div v-else>
                        <h3>Loading skill position ....</h3>
                    </div>
                    <router-link :to="'/skill'" class="btn btn-primary"> &lt; Back </router-link>

                </div>
            </div>
        </main>
    </div>
</template>

<script>
import { defineComponent, ref, onMounted } from 'vue';
export default defineComponent({
    data() {
        return {

        }
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


        const startDrag = (event, item) => {
            console.log("dang keo " + item.Position)
            event.dataTransfer.dropEffect = 'move'
            event.dataTransfer.effectAllowed = 'move'
            event.dataTransfer.setData('itemPosition', item.Position)
        }

        const updatePosition = (skill1Position = null, skill2Position = null) => {
            const requestData = {
                skill1Position: skill1Position,
                skill2Position: skill2Position
            };

            axios.post('api/updateSkillPosition', requestData)
                .then((response) => {
                    console.log("skill1: " + skill1Position + "| skill2: " + skill2Position)
                    // xử trí khi thành công
                    console.log(response);
                    getSkills();

                })
                .catch((error) => {
                    // xử trí khi bị lỗi
                    console.log(error);
                });
        };

        const onDrop = (event, skill) => {
            console.log("vua tha " + skill.Position)
            const itemPosition = +event.dataTransfer.getData('itemPosition');
            console.log("item position cho onDrop:" + itemPosition)
            console.log("item position nhan onDrop:" + skill.Position)
            if (itemPosition !== skill.Position) {
                updatePosition(itemPosition, skill.Position);
            }
        };

        return { getSkills, skillList, startDrag, onDrop, updatePosition }
    },
})
</script>

<style scoped>
.drop-zone {
    width: 65%;
    margin: 50px auto;
    /* background-color: #ecf0f1; */
    padding: 10px;
    min-height: 10px;
}

.drag-el {
    background-color: #3498db;
    color: #ffffff;
    padding: 5px;
    margin-bottom: 10px;
    border-radius: 5px;
}

.drag-el:hover {
    background-color: rgb(100, 210, 86);

}
</style>