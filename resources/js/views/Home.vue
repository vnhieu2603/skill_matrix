<!-- <template>
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="2000">
                <img src="https://media.wired.com/photos/598e35fb99d76447c4eb1f28/master/pass/phonepicutres-TA.jpg"
                    class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item" data-bs-interval="2000">
                <img src="https://us.123rf.com/450wm/serhatbozkurt/serhatbozkurt2305/serhatbozkurt230500115/206142688-traveling-girl-photographer-with-shoulder-bag-making-an-inspiring-landscape-of-dramatic-clouds.jpg?ver=6"
                    class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item" data-bs-interval="2000">
                <img src="https://www.recordnet.com/gcdn/presto/2021/03/22/NRCD/9d9dd9e4-e84a-402e-ba8f-daa659e6e6c5-PhotoWord_003.JPG?width=660&height=425&fit=crop&format=pjpg&auto=webp"
                    class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</template>
  
<script>
import { defineComponent, ref, onMounted, computed, } from 'vue';

export default defineComponent({
    data() {
        return {
            // timeTransition: 5000
        }
    },

    setup() {

        const timeTransition = ref();
        onMounted(() => {
            timeTransition.value = 2000;
        });
        return { timeTransition }
    }
})
</script>
   -->
<style scoped>
table th {
    cursor: pointer;
}
</style>
<template>
    <div>
        <table>
            <thead>
                <tr>
                    <th @click="sortColumn('column1')">Column 1</th>
                    <th @click="sortColumn('column2')">Column 2</th>
                    <th @click="sortColumn('column3')">Column 3</th>

                    <!-- Thêm thêm cột cần sắp xếp ở đây -->
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in tableData" :key="index">
                    <td>{{ item.column1 }}</td>
                    <td>{{ item.column2 }}</td>
                    <td>{{ item.column3 }}</td>

                    <!-- Thêm thêm cột cần sắp xếp ở đây -->
                </tr>
            </tbody>
        </table>
    </div>
</template>
  
<script>
import { ref } from 'vue';

export default {
    setup() {
        const tableData = ref([
            { column1: 5, column2: 8, column3: 9 },
            { column1: 3, column2: 9, column3: 4 },
            { column1: 2, column2: 12, column3: 10 },
            { column1: 3, column2: 9, column3: 6 },


            // Thêm dữ liệu cho các cột khác ở đây
        ]);

        const sortColumn = (columnName) => {

            tableData.value.sort((a, b) => a[columnName] - b[columnName]);

        };

        return {
            tableData,
            sortColumn,
        };
    },
};
</script>
  