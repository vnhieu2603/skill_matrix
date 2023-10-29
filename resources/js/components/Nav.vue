<template>
    <header class="py-3 border shadow">
        <div class="container">
            <div class="row">
                <div class="col-2">
                    <h2>
                        <router-link to="/" style="text-decoration: none; color: #30b3ba;"
                            @click="setActiveLink('home')">Skill
                            Matrix </router-link>
                    </h2>
                </div>
                <div class="col-10 d-flex justify-content-center align-items-center">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <div class="container-fluid">
                            <div class="collapse navbar-collapse" id="navbarNav">
                                <ul class="navbar-nav">
                                    <li class="nav-item">
                                        <router-link class="nav-link" :class="{ activeBtn: activeLink === 'home' }" to="/"
                                            @click="setActiveLink('home')">Home</router-link>
                                    </li>

                                    <li class="nav-item">
                                        <router-link class="nav-link" :class="{ activeBtn: activeLink === 'member' }"
                                            to="/member" @click="setActiveLink('member')">Member</router-link>
                                    </li>
                                    <li class="nav-item">
                                        <router-link class="nav-link" :class="{ activeBtn: activeLink === 'skill' }"
                                            to="/skill" @click="setActiveLink('skill')">Skill</router-link>
                                    </li>
                                    <li class="nav-item">
                                        <router-link class="nav-link" :class="{ activeBtn: activeLink === 'level' }"
                                            to="/level" @click="setActiveLink('level')">Level</router-link>
                                    </li>
                                    <li class="nav-item">
                                        <router-link class="nav-link" :class="{ activeBtn: activeLink === 'skillMatrix' }"
                                            to="/skillMatrix" @click="setActiveLink('skillMatrix')">Skill
                                            Matrix</router-link>
                                    </li>
                                </ul>
                            </div>

                        </div>

                    </nav>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
export default {
    data() {
        return {
            activeLink: null,
        }
    },
    methods: {
        setActiveLink(link) {
            this.activeLink = link;
        }
    }
}
</script>
<style scoped>
.activeBtn {
    border-radius: 10px;
    background-color: #84eff5;
    /* Đặt màu nền tùy ý */
    color: #fff;
    /* Đặt màu chữ tùy ý */
}
</style>