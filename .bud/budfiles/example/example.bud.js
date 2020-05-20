/**
 * Starter Budfile
 *
 * Run `yarn generate example`
 */
module.exports = {
  name: 'example',
  description: 'Customize in .bud/budfiles',
  default: {
    componentName: 'ComponentName',
  },
  prompts: [
    {
      type: 'input',
      name: 'componentName',
      message: 'ComponentName',
      initial: 'ExampleComponent',
      required: true,
    },
  ],
  actions: [
    {
      action: 'template',
      template: 'Component.js.bud',
      path: 'src/components/{{componentName}}.js',
      parser: 'babel',
    },
  ],
}
