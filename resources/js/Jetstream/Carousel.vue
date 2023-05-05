<template>
  <div>
    <carousel :per-page="3">
      <slide v-for="item in items" :key="item.id">
        <img :src="item.image" alt="">
        <div>{{ item.title }}</div>
      </slide>
    </carousel>
  </div>
</template>

<script>
  import { Carousel, Slide } from 'vue-carousel';

  export default {
    components: {
      Carousel,
      Slide,
    },
    data() {
      return {
        items: [
          {
            id: 1,
            title: 'Item 1',
            image: 'https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885_1280.jpg',
          },
          {
            id: 2,
            title: 'Item 2',
            image: 'https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885_1280.jpg',
          },
          {
            id: 3,
            title: 'Item 3',
            image: 'https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885_1280.jpg',
          },
          {
            id: 4,
            title: 'Item 4',
            image: 'https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885_1280.jpg',
          },
        ],
      };
    },
  };
</script>
