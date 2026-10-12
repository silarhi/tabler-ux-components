import { defineSilarhiDocs } from '@silarhi/docs-kit'

const group = (label, directory) => ({ label, collapsed: false, items: [{ autogenerate: { directory } }] })

export default defineSilarhiDocs({
    slug: 'tabler-ux-components',
    title: 'Tabler UX Components',
    description: 'Tabler-flavored Twig UX components for Symfony, following the shadcn composition pattern.',
    sidebar: [
        { label: 'Getting started', items: [{ autogenerate: { directory: 'getting-started' } }] },
        group('Feedback', 'components/feedback'),
        group('Actions', 'components/actions'),
        group('Content', 'components/content'),
        group('Overlays', 'components/overlays'),
        group('Navigation', 'components/navigation'),
        group('Layout', 'components/layout'),
        group('Data display', 'components/data'),
    ],
})
