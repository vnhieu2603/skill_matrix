import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import NotFound from '../views/404.vue'
//level
import Level from '../views/level/Level.vue'
import AddLevel from '../views/level/AddLevel.vue'
import EditLevel from '../views/level/EditLevel.vue'
//member
import Member from '../views/member/Member.vue'
import AddMember from '../views/member/AddMember.vue'
import EditMember from '../views/member/EditMember.vue'
//skill
import Skill from '../views/skill/Skill.vue'
import AddSkill from '../views/skill/AddSkill.vue'
import ChangeSkillPosition from '../views/skill/ChangeSkillPosition.vue'

//memskill
import SkillMatrix from '../views/skillMatrix/SkillMatrix.vue'



const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'homePage',
            component: Home
        },
        {
            path: '/level',
            name: 'levelPage',
            component: Level
        }, {
            path: '/addLevel',
            name: 'addLevelPage',
            component: AddLevel
        }, {
            path: '/member',
            name: 'memberPage',
            component: Member
        }, {
            path: '/addMember',
            name: 'addMemberPage',
            component: AddMember
        }, {
            path: '/member/:MemCode',
            name: 'editMemberPage',
            component: EditMember
        }, {
            path: '/skill',
            name: 'skillPage',
            component: Skill
        }, {
            path: '/addSkill',
            name: 'addSkillPage',
            component: AddSkill
        }, {
            path: '/changeSkillPosition',
            name: 'changeSkillPositionPage',
            component: ChangeSkillPosition
        }, {
            path: '/skillMatrix',
            name: 'skillMatrixPage',
            component: SkillMatrix
        }, {
            path: '/level/:levelNumber',
            name: 'edit-level-detail',
            component: EditLevel,
        }
        // ,
        // {
        //     path: '/:pathMatch(.*)*',
        //     component: NotFound,
        // }
    ]
})

export default router
