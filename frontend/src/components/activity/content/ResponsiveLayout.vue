<template>
  <LayoutCard
    v-resizeobserver.debounce="onResize"
    class="ec-responsivelayout"
    :class="{
      'ec-responsivelayout--layout-mode': layoutMode,
      'ec-responsivelayout--read-mode': !layoutMode,
    }"
    :is-root="isRoot"
    :layout-mode="layoutMode"
  >
    <template #header>
      {{ $tc('contentNode.responsiveLayout.name') }}
      <menu-cardless-content-node :content-node="contentNode" />
    </template>
    <div v-if="!contentNode.loading" class="ec-responsivelayout__container">
      <LayoutItem
        v-if="!isDefaultVariant && (hasAsideTop || layoutMode)"
        :basis="'min(' + ASIDE_CONTENT_WIDTH + 'px,100%)'"
        grow="1"
      >
        <div class="d-flex flex-column flex-grow-1 ec-responsivelayout__slot">
          <p v-if="layoutMode" class="text-center">
            {{ $tc('contentNode.responsiveLayout.printAboveMainContent') }}
          </p>
          <draggable-content-nodes
            slot-name="aside-top"
            :layout-mode="layoutMode"
            :parent-content-node="contentNode"
            :disabled="disabled"
            direction="row"
          />
        </div>
      </LayoutItem>
      <LayoutItem :basis="'min(' + MAIN_CONTENT_WIDTH + 'px,100%)'" grow="3">
        <div class="d-flex flex-column flex-grow-1 ec-responsivelayout__slot">
          <p v-if="layoutMode" class="text-center">
            {{ $tc('contentNode.responsiveLayout.mainContent') }}
          </p>
          <draggable-content-nodes
            slot-name="main"
            :layout-mode="layoutMode"
            :parent-content-node="contentNode"
            :disabled="disabled"
            direction="column"
          />
        </div>
      </LayoutItem>
      <LayoutItem
        :basis="'min(' + ASIDE_CONTENT_WIDTH + 'px,100%)'"
        grow="1"
        class="justify-space-between ec-responsivelayout__aside"
      >
        <div
          v-if="isDefaultVariant && (hasAsideTop || layoutMode)"
          class="d-flex flex-column ec-responsivelayout__slot"
          :class="{ 'flex-grow-1': !layoutMode }"
        >
          <p v-if="layoutMode" class="text-center">
            {{ $tc('contentNode.responsiveLayout.printAboveMainContent') }}
          </p>
          <draggable-content-nodes
            slot-name="aside-top"
            :layout-mode="layoutMode"
            :parent-content-node="contentNode"
            :disabled="disabled"
            direction="row"
          />
        </div>
        <v-sheet
          v-if="!layoutMode && isDefaultVariant && hasAsideTop && hasAsideBottom"
          tile
          class="flex-grow-1"
        />
        <div
          v-if="hasAsideBottom || layoutMode"
          class="d-flex flex-column ec-responsivelayout__slot"
          :class="{ 'flex-grow-1': !layoutMode }"
        >
          <p v-if="layoutMode" class="text-center">
            {{ $tc('contentNode.responsiveLayout.printBelowMainContent') }}
          </p>
          <draggable-content-nodes
            slot-name="aside-bottom"
            :layout-mode="layoutMode"
            :parent-content-node="contentNode"
            :disabled="disabled"
            direction="row"
          />
        </div>
      </LayoutItem>
    </div>
  </LayoutCard>
</template>

<script>
import { contentNodeMixin } from '@/mixins/contentNodeMixin.js'
import DraggableContentNodes from '@/components/activity/DraggableContentNodes.vue'
import LayoutItem from '@/components/activity/content/layout/LayoutItem.vue'
import MenuCardlessContentNode from '@/components/activity/MenuCardlessContentNode.vue'
import LayoutCard from '@/components/activity/content/layout/LayoutCard.vue'
import { groupBy } from 'lodash'

const ASIDE_CONTENT_WIDTH = 400
const MAIN_CONTENT_WIDTH = 700
const GAP = 1

export default {
  name: 'ResponsiveLayout',
  components: {
    DraggableContentNodes,
    MenuCardlessContentNode,
    LayoutCard,
    LayoutItem,
  },
  mixins: [contentNodeMixin],
  data() {
    return {
      ASIDE_CONTENT_WIDTH,
      MAIN_CONTENT_WIDTH,
      clientWidth: ASIDE_CONTENT_WIDTH + MAIN_CONTENT_WIDTH + GAP,
    }
  },
  computed: {
    hasAsideTop() {
      return this.childrenContentNodesBySlot['aside-top']?.length > 0
    },
    hasAsideBottom() {
      return this.childrenContentNodesBySlot['aside-bottom']?.length > 0
    },
    childrenContentNodesBySlot() {
      return groupBy(this.contentNode.children().items, 'slot')
    },
    isDefaultVariant() {
      return this.clientWidth >= ASIDE_CONTENT_WIDTH + MAIN_CONTENT_WIDTH + GAP
    },
    isRoot() {
      return this.contentNode._meta.self === this.contentNode.root()._meta.self
    },
  },
  methods: {
    onResize({ width }) {
      this.clientWidth = width
    },
  },
}
</script>

<style lang="scss">
.ec-responsivelayout--layout-mode {
  border: 1px solid black;
  border-radius: 10px;
}

.ec-responsivelayout__container {
  display: flex;
  gap: 1px;
  flex-wrap: wrap;
}

.ec-responsivelayout--layout-mode .ec-responsivelayout__container {
  padding: 4px;
  gap: 16px;
}

.ec-responsivelayout__container {
  background-color: #ccc;
  border-bottom-left-radius: 9px;
  border-bottom-right-radius: 9px;
}

.ec-responsivelayout--layout-mode .ec-layout-item {
  border-radius: 4px;
  grid-template-rows: auto 1fr;
  gap: 8px;
}

.ec-responsivelayout--layout-mode .ec-draggable-area {
  padding: 0 8px 8px;
}

.ec-responsivelayout--layout-mode .ec-responsivelayout__slot {
  border: 1px dashed rgba(0, 0, 0, 0.3);
  border-radius: 4px;
  padding: 0 8px;
}

.ec-responsivelayout__aside {
  gap: 1px;
}
</style>
