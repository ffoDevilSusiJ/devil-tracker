<template>
  <div class="members">
    <div class="members__container">
      <div class="members__list">
        <div v-for="member in users" :class="{member: true, current_user: isUser(member.username)}">
          <div class="member__avatar">
            <img :src="member.avatar_path" alt="">
          </div>
          <div v-if="member.role_id === 1" class="member__admin material-icons">person</div>
          <div class="member__username">{{ member.username }}</div>
          <div class="member__email">{{ member.email }}</div>
          <div class="member__actions">
            <div v-if="member.role_id !== 1" @click="$emit('edit', member)" class="member__action change material-icons">manage_accounts</div>
            <div v-if="member.role_id !== 1" @click="$emit('delete', member)" class="member__action delete material-icons">delete</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
  
<script>

export default {
  name: 'MembersListComponent',
  props: {
    users: Array
  },
  methods: {
    isUser(username) {
      return document.getElementsByClassName("user-bar__username")[0].textContent == username;
    }
  }
}
</script>


<style lang="scss">
@import "resources/assets/sass/vars.scss";
.current_user {
  background-color: $low-contrast-hover!important;
}
.members {
  width: 500px;
  height: 500px;

  &__container {
    width: 100%;
    height: 100%;
    &::-webkit-scrollbar {
      width: 6px;
    }

    &::-webkit-scrollbar-track {
      background: white;
    }

    &::-webkit-scrollbar-thumb {
      background-color: $low-contrast-hover;
      margin-left: 5px;
      border-left: 3px solid white;

    }
  }
}

.member {
  display: flex;
  position: relative;
  align-items: center;
  background-color: $low-contrast-base;
  padding: 15px;
  border-radius: 5px;
  margin-bottom: 15px;
  &__avatar {
    margin-right: 20px;
    img {
      height: 40px;
      width: auto;
    }
  }
  &__admin {
    color: darkorange;
    position: absolute;
    left: 0;
  }
  &__username {
    font-weight: 600;
    margin-right: 15px;
  }
  &:hover {
    background-color: $low-contrast-hover;
    .member__actions {
      opacity: 1;
    }
  }
  .member__actions {
    opacity: 0;
    position: absolute;
    right: 15px;
    color: #2b2b2b47;
    .member__action {
      position: relative;
      cursor: pointer;
      &:hover {
        color: #2b2b2bcc;
        &::before {
          display: block;
        }
      }
      &::before {
        position: absolute;
        top: -25px;
        font-weight: 600;
        display: none;
        font-size: 14px;
        padding: 3px;
        color: white;
        background-color: black;
      }
    }
    .delete::before {
      content: 'Исключить';
    }
    .change::before {
      content: 'Изменить';
    }
  }
}
</style>