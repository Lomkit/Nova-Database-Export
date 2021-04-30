Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'export',
      path: '/export',
      component: require('./components/Tool'),
    },
  ])
})
