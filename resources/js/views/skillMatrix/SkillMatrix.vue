<template>
    <main class="py-5">
        <div class="container">
            <div class="content">
                <h1>Skill matrix</h1>
                <div class="row">
                    <div class="col-3"></div>
                    <div class=" col-6">
                        <div v-if="levelList.length">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>color</th>
                                        <th>description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="level in levelList">
                                        <td :style="'background-color: ' + level.color" style="text-align: right;"> {{
                                            level.levelNumber }} </td>

                                        <td>{{ level.description }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-else>
                            <h3>Loading level ....</h3>
                        </div>
                    </div>
                    <div class="col-3"></div>
                </div>
                <div class="row">
                    <div class="col-12 ">
                        <div v-if="memskills.length">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ skillOrder }}
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><button class="btn btn-primary dropdown-item" @click="sortBySkillNameASC">Sort
                                            skills in ascending alphabetical order</button></li>
                                    <li><button class="btn btn-primary dropdown-item" @click="sortBySkillNameDESC">Sort
                                            skills in descending alphabetical order</button></li>
                                    <li><button class="btn btn-primary dropdown-item" @click="noSort">Normal</button></li>
                                </ul>
                            </div>
                            <div class="checkbox-container">
                                <div v-for="skill in skillList" :key="skill.Id" class="checkbox-item">
                                    <input type="checkbox" :value="skill.Id" :checked="true" :ref="'checkBox_' + skill.Id"
                                        @click="clickCheckBox(skill.Id)">
                                    {{ skill.Name }}
                                </div>
                                <a class="chooseAllBtn" @click="chooseAllSkill(skillList)"> Choose all </a>

                            </div>

                            <table class="table table-bordered" style="border-collapse: collapse;">
                                <colgroup>
                                    <col>
                                    <col>
                                    <col>
                                    <col v-for="skill in (sorted === 'asc' ? sortedAscSkillList : (sorted === 'desc' ? sortedDescSkillList : skillList))"
                                        :key="skill.Id" :style="getColumnStyle(skill.Id)">
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th class="vertical-text" @click="sortTable(skill.Id)" style="cursor: pointer;"
                                            v-for=" skill  in  (sorted === 'asc' ? sortedAscSkillList : (sorted === 'desc' ? sortedDescSkillList : skillList))">
                                            {{ skill.Name }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="( member, index ) in  memberList " :key="index">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ member.MemCode }}</td>
                                        <td>{{ member.Name }}</td>
                                        <template v-for=" memSkill in memskills " :key="memSkill.Id">
                                            <template v-for=" skill in skillList ">
                                                <td
                                                    v-if="memSkill.memCode === member.MemCode && skill.Id === memSkill.skillId">
                                                    <div class="skill-list">
                                                        <select name="levelNumber" class="levelSelect"
                                                            :id="'select_' + memSkill.memCode + '_' + skill.Id"
                                                            @click.once="saveOldValue($event.target.value)"
                                                            @change="showPopup(memSkill.memCode, skill.Id, $event.target.value)"
                                                            :style="'background-color: ' + getLevelColor(memSkill.levelNumber)"
                                                            style="width: 100%; height: 100%; margin: auto; padding: 0;">
                                                            <option value="" style="text-align: center;"> - </option>
                                                            <option v-for=" level  in  levelList " :key="level.levelNumber"
                                                                :value="level.levelNumber"
                                                                :selected="level.levelNumber == memSkill.levelNumber">
                                                                {{ level.levelNumber }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </td>
                                            </template>
                                        </template>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-else>
                            <h3>Loading skill matrix ....</h3>
                        </div>
                        <div class="wrapper">
                            <div class="overlay modal" v-if="showingPopup" @click.self="closePopup">
                                <form @submit.prevent="storeMemskills">
                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h2>Choose time skill up</h2>
                                            </div>
                                            <div class="modal-body">
                                                <input type="datetime-local" v-model="memSkillToInsert.timeSkillUp"
                                                    name="timeSkillUp" required>
                                                <input type="hidden" name="codeOfMember"
                                                    v-model="memSkillToInsert.codeOfMember" placeholder="Code of Member" />
                                                <input type="hidden" name="idOfSkill" v-model="memSkillToInsert.idOfSkill"
                                                    placeholder="ID of Skill" />
                                                <input type="hidden" name="numberOfLevel"
                                                    v-model="memSkillToInsert.numberOfLevel"
                                                    placeholder="Number of Level" />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-info">Submit</button>
                                                <button @click="closePopup()" class="btn btn-danger">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template> 

<script>
import { defineComponent, ref, reactive, toRefs, onMounted, computed, } from 'vue';

export default defineComponent({
    data() {
        return {
            oldValue: null,
            currentMemcode: null,
            currentSkillId: null,
            showingPopup: false,
            sorted: '',
            sortBy: '',
            columnVisibility: {},

            memberList: [], // Danh sách các hàng trong bảng
            countSort: 0, // Cột hiện đang được sắp xếp
            memCodeOrder: [],
            currentColumn: 0
        }
    },

    setup() {
        const showingPopup = ref(false);

        const sorted = ref('sorted');
        const memskills = ref([])
        const getMemskills = (sortBy = null, sortOrder = null) => {
            const queryParams = {
                sortBy: sortBy,
                sortOrder: sortOrder,
            };
            axios.get('api/memskills', {
                params: queryParams,
            })
                .then((response) => {
                    // xử trí khi thành công
                    console.log(response);
                    memskills.value = response.data;
                })
                .catch((error) => {
                    // xử trí khi bị lỗi
                    console.log(error);
                });
        };

        onMounted(() => {
            noSort();
        });
        const noSort = () => {
            getMemskills();
            sorted.value = ''
        };
        const sortBySkillNameASC = () => {
            getMemskills('s.Name', 'asc');
            sorted.value = 'asc'

        };
        const sortBySkillNameDESC = () => {
            getMemskills('s.Name', 'desc');
            sorted.value = 'desc'
        };


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
        getLevels();

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
        const sortedAscSkillList = computed(() => {
            return [...skillList.value].sort((a, b) => {
                return a.Name.localeCompare(b.Name);
            });
        });

        const sortedDescSkillList = computed(() => {
            return [...skillList.value].sort((a, b) => {
                return b.Name.localeCompare(a.Name);
            });
        });

        const skillOrder = computed(
            function () {
                if (sorted.value == '') {
                    return "Normal"
                }
                else if (sorted.value == 'asc') {
                    return "Sort skills in ascending alphabetical order"
                }
                else {
                    return "Sort skills in descending alphabetical order"
                }
            }
        )

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

        let memSkillToInsert = reactive({
            codeOfMember: "",
            idOfSkill: "",
            numberOfLevel: "",
            timeSkillUp: ""
        });
        const storeMemskills = () => {
            axios.post('api/memskills', memSkillToInsert)
                .then((response) => {
                    // xử trí khi thành công
                    console.log(response);
                    showingPopup.value = false;
                    if (sorted.value == "") {
                        noSort()
                    } else if (sorted.value == "asc") {
                        sortBySkillNameASC()
                    } else {
                        sortBySkillNameDESC()
                    }

                    // levels.value = response.data;
                })
                .catch((error) => {
                    // xử trí khi bị lỗi
                    console.log(error);
                });
        };

        return {
            memskills, levelList, memberList, skillList, sortedAscSkillList, sortedDescSkillList, memSkillToInsert, storeMemskills, showingPopup,
            sortBySkillNameASC, sortBySkillNameDESC, noSort, sorted, skillOrder
        }
    },
    mounted() {
        console.log("The component is mounted")

    },

    updated() {
        console.log("The component is updated")
    },

    methods: {
        getLevelColor(levelNumber) {
            const level = this.levelList.find(level => level.levelNumber == levelNumber);
            return level ? level.color : '';
        },
        saveOldValue(value) {
            console.log("old value: " + value)
            this.oldValue = value
        },
        showPopup(memCode, skillId, value) {
            // Logic to show the popup
            this.showingPopup = true;
            this.memSkillToInsert.codeOfMember = memCode;
            this.memSkillToInsert.idOfSkill = skillId;
            this.memSkillToInsert.numberOfLevel = value;
            console.log(memCode, skillId, value)

            this.currentMemcode = memCode;
            this.currentSkillId = skillId;
        },
        closePopup() {
            const selectId = `select_${this.currentMemcode}_${this.currentSkillId}`;
            const selectedValue = document.querySelector(`#${selectId}`);
            selectedValue.value = this.oldValue;
            // Logic to close the popup
            this.showingPopup = false;
        },

        getColumnStyle(skillId) {
            // Xác định thuộc tính style của cột dựa trên trạng thái trong columnVisibility
            const visibility = this.columnVisibility[skillId] ? 'collapse' : 'visible';
            return `visibility: ${visibility};`;
        },
        clickCheckBox(skillId) {
            console.log(this.columnVisibility)
            console.log("You click " + skillId)
            this.columnVisibility[skillId] = !this.columnVisibility[skillId];
            console.log(this.columnVisibility)
        },

        chooseAllSkill() {
            this.skillList.forEach(skill => {
                this.$refs['checkBox_' + skill.Id][0].checked = true;
            });
            this.columnVisibility = {};
            console.log("isChecked: " + this.isChecked)

        },
        sortTable($column) {
            console.log("column skill Id: " + $column);
            if ($column !== this.currentColumn) {
                this.currentColumn = $column
                this.countSort = 0;
            }
            if (this.countSort == 0) {

                axios.get('api/memskillsSortBylevelNumberOfSkill/' + $column)
                    .then((response) => {
                        // Xử lý khi thành công
                        console.log(response);

                        // Lấy danh sách memCode từ kết quả API
                        this.memCodeOrder = response.data.map(item => item.memCode);
                        console.log("memCodeOrder: " + this.memCodeOrder);

                        // Sắp xếp memberList dựa trên memCodeOrder

                        this.memberList = this.memCodeOrder.map((memCode) =>
                            this.memberList.find((member) => member.MemCode === memCode)
                        );
                        console.log(this.memberList);

                    })
                    .catch((error) => {
                        // Xử lý khi gặp lỗi
                        console.log(error);
                    });
                this.countSort++;
            } else if (this.countSort == 1) {
                const queryParams = {
                    sortBy: 'desc'
                };
                axios.get('api/memskillsSortBylevelNumberOfSkill/' + $column, {
                    params: queryParams,
                })
                    .then((response) => {
                        // Xử lý khi thành công
                        console.log(response);

                        // Lấy danh sách memCode từ kết quả API
                        this.memCodeOrder = response.data.map(item => item.memCode);
                        console.log("memCodeOrder: " + this.memCodeOrder);

                        // Sắp xếp memberList dựa trên memCodeOrder
                        this.memberList = this.memCodeOrder.map((memCode) =>
                            this.memberList.find((member) => member.MemCode === memCode)
                        );
                        console.log("day la column lan 3");
                    })
                    .catch((error) => {
                        // Xử lý khi gặp lỗi
                        console.log(error);
                    });
                this.countSort++;
            } else if (this.countSort == 2) {
                console.log("this is no sort column")
                this.memCodeOrder.sort()
                console.log(this.memCodeOrder)
                // Sắp xếp memberList dựa trên memCodeOrder
                this.memberList = this.memCodeOrder.map((memCode) =>
                    this.memberList.find((member) => member.MemCode === memCode)
                );
                console.log(this.memberList)
                this.countSort = 0;
            }
        },
    },
})
</script>


<style scoped lang="css">
.vertical-text {
    /* Xoay chữ về dọc */
    writing-mode: vertical-rl;
    /* Xoay 180 độ để hiển thị đúng hướng */
    transform: rotate(180deg);
    text-align: center;
    /* Không ngắt dòng văn bản */
    white-space: nowrap;
}

.modal {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1060;
    display: block;
    width: 100%;
    height: 100%;
    overflow-x: hidden;
    overflow-y: auto;
    outline: 0;
    background-color: rgba(0, 0, 0, .2);
}

.overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    /* Màu nền lớp mờ */
    z-index: 100;
    /* Đảm bảo lớp mờ hiển thị phía trên nền */
    display: flex;
    justify-content: center;
    align-items: center;
}

.fade {
    transition: opacity .15s linear;
}

.modal-dialog {
    position: relative;
    width: 100%;
    margin: 0.5rem;
    pointer-events: none;
}

.modal-dialog {
    max-width: 500px;
    margin: 5.75rem auto;
}

.modal.fade .modal-dialog {
    transition: transform .3s ease-out;
    transform: translate(0, -50px);
}

.modal-content {
    position: relative;
    display: flex;
    flex-direction: column;
    width: 100%;
    pointer-events: auto;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(0, 0, 0, .2);
    border-radius: 0.3rem;
    outline: 0;
}

.modal-header {
    display: flex;
    flex-shrink: 0;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1rem;
    border-bottom: 1px solid #dee2e6;
    border-top-left-radius: calc(0.3rem - 1px);
    border-top-right-radius: calc(0.3rem - 1px);
}

.modal-body {
    position: relative;
    flex: 1 1 auto;
    padding: 1rem;
}

.modal-footer {
    display: flex;
    flex-wrap: wrap;
    flex-shrink: 0;
    align-items: center;
    justify-content: flex-end;
    padding: 0.75rem;
    border-top: 1px solid #dee2e6;
    border-bottom-right-radius: calc(0.3rem - 1px);
    border-bottom-left-radius: calc(0.3rem - 1px);
}

.checkbox-container {
    display: flex;
    flex-wrap: wrap;
}

.checkbox-item {
    display: inline-block;
    margin-right: 10px;
}

.chooseAllBtn {
    color: #000;
}

.chooseAllBtn:hover {
    color: #266182;
    cursor: pointer;
}
</style>