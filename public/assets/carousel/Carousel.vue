<template>
    <div class="carousel">
        <div class="carousel-inner">
            <carousel-item v-for="(slide, welcome) in slides" 
            :slide="slide"
            :key="'item-${welcome}'"
            ></carousel-item>
        </div>
    </div>
</template>

<script>
import CarouselItem from "./CarouselItem.vue"
export default{
    props: ['slides'],
    components: { CarouselItem }
}
</script>

<style scoped>
  .carousel{
    display: flex;
    justify-content: center;
  }

  .carousel-inner{
    position: relative;
    width: 900px;
    height: 400px;
    overflow: hidden;
  }
</style>