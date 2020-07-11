import ApiService from './api.service'

class PropertyService extends ApiService {
  constructor () {
    super({ segment: 'properties' })
  }

  list() {
    return this.client.get();
  }

  store (username) {
    return this.client.post('', {
      username: username
    })
  }

  topics (repositoryId) {
    return this.client.get(`topics/${repositoryId}`)
  }
}

export default new PropertyService()
