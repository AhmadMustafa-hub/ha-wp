/* globals React, wp */
const { FocalPointPicker } = wp.components
const { useDispatch, useSelect } = wp.data

export const featuredImageCenter = {
  hook: 'editor.PostFeaturedImage',
  name: 'ws/modify-featured-image',
  func: FeaturedImage => {
    return (props) => {
      const { media } = props
      const { meta } = useSelect(select => ({
        meta: select('core/editor').getEditedPostAttribute('meta')
      }))
      const { editPost } = useDispatch('core/editor')
      const setMeta = keyAndValue => {
        editPost({ meta: keyAndValue })
      }
      return (
        <>
          { media && media.source_url && (
            <FocalPointPicker
              url={ media.source_url }
              dimensions={ {
                width: media.width,
                height: media.height
              } }
              onChange={ newValue => setMeta({ '_featured_image_x': newValue.x, '_featured_image_y': newValue.y }) }
              value={ {
                x: meta['_featured_image_x'] === '' ? 0.5 : meta['_featured_image_x'],
                y: meta['_featured_image_y'] === '' ? 0.5 : meta['_featured_image_y']
              } }
            />
          ) }
          <div className={ media && media.source_url ? 'hide-featured-image' : ''}>
            <FeaturedImage { ...props } />
          </div>
        </>
      )
    }
  }
}
