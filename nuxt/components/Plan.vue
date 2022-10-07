<template>
  <div class="pricing-table is-horizontal">
    <div class="pricing-plan is-active">
      <div class="plan-header">{{ plan.description }}</div>

      <div class="plan-footer">
        <div class="plan-price">
          <span class="plan-price-amount has-text-info"
            ><span class="plan-price-currency">€</span
            >{{ parseInt(plan.price, 10) / 100 }}</span
          >/ {{ plan.cycle }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    plan: {
      required: true,
      type: Object,
    },
  },
};
</script>
